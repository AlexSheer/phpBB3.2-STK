<?php
/**
*
* @package Support Toolkit - Profile List
* @version $Id$
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

class profile_list
{
	function display_options()
	{
		global $db, $template, $user, $phpbb_container, $request, $lang;

		$submit = $request->variable('sa', false);

		page_header(user_lang('PROFILE_LIST'));

		$user->add_lang('memberlist');

		// Handle delete
		if ($submit)
		{
			$uids = $request->variable('marked_user_id', array(0, 0));
			if (confirm_box(true) || (@phpversion() >= '7.0.0'))
			{
				if (!function_exists('user_delete'))
				{
					require PHPBB_ROOT_PATH . 'includes/functions_user.' . PHP_EXT;
				}

				// Delete them all
				foreach ($uids as $uid)
				{
					user_delete('remove', $uid);
				}

				trigger_error($lang['USERS_DELETE_SUCCESSFULL']);
			}
			else
			{
				$hidden = build_hidden_fields(array('marked_user_id' => $uids));
				confirm_box(false, $lang['USERS_DELETE_CONFIRM'], $hidden, 'confirm_body.html', STK_DIR_NAME . '/index.' . PHP_EXT . '?c=admin&amp;t=profile_list&amp;sa=' . true);
			}
		}

		$display = $request->variable('display', '');
		$start = $request->variable('start', 0);
		$limit = $request->variable('limit', 20);
		$order_by = $request->variable('order', '');
		$order_dir = ($request->variable('dir', 'DESC') == 'DESC') ? 'DESC' : 'ASC';
		$empty_only = (!isset($_GET['go']) || isset($_POST['empty_only']) || isset($_GET['empty_only'])) ? true : false;

		// Build Pagination URL
		$pagination = $phpbb_container->get('pagination');

		$base_url = 't=profile_list&amp;go=1';
		$base_url .= ($display) ? '&amp;display=' . $display : '';
		$base_url .= ($empty_only) ? '&amp;empty_only=1' : '';
		$base_url .= ($limit != 20) ? '&amp;limit=' . $limit : '';
		$base_url .= ($order_by) ? '&amp;order=' . $order_by : '';
		$base_url .= ($order_dir != 'DESC') ? '&amp;dir=ASC' : '';
		$base_url = append_sid(STK_INDEX, $base_url);

		/*
		* Filter stuff
		*/
		$options = array(
			'pf_phpbb_icq'			=> 'ICQ',
			'pf_phpbb_skype'		=> 'SKYPE',
			'pf_phpbb_facebook'		=> 'FACEBOOK',
			'pf_phpbb_twitter'		=> 'TWITTER',
			'pf_phpbb_yahoo'		=> 'YAHOO',
			'pf_phpbb_youtube'		=> 'YOUTUBE',
			'user_jabber'			=> 'JABBER',
			'pf_phpbb_website'		=> 'WEBSITE',
			'pf_phpbb_occupation'	=> 'OCCUPATION',
			'pf_phpbb_interests'	=> 'INTERESTS',
			'pf_phpbb_location'		=> 'LOCATION',
			'user_sig'				=> 'SIGNATURE',
		);

		if (version_compare(PHPBB_VERSION, '3.3.1', '<'))
		{
			$options = array_merge($options, array(
				'pf_phpbb_googleplus'	=> 'GOOGLEPLUS',
				'pf_phpbb_aol'			=> 'AOL',
			));
		}

		$profile_where = '';
		$extra = '';
		$profile = '';

		foreach ($options as $option => $lang_key)
		{
			$template->assign_block_vars('options', array(
				'OPTION'	=> $option,
				'LANG'		=> isset($lang[$lang_key]) ? $lang[$lang_key] : $lang_key,
				'SELECTED'	=> ($display == $option) ? true : false,
			));

			if ($empty_only)
			{
				$profile_where .= (($profile_where == '') ? ' AND (' : ' OR ');
				$extra = ', ' . PROFILE_FIELDS_DATA_TABLE . ' p';
				$profile = ' AND u.user_id = p.user_id ';

				switch ($db->get_sql_layer())
				{
					case 'mssql'		:
					case 'mssqli'		:
					case 'mssqlnative'	:
						if ($option == 'user_sig')
						{
							$profile_where .= "DATALENGTH({$option}) > 0";
						}
						else
						{
							$profile_where .= "{$option} <> ''";
						}
					break;

					default:
						$profile_where .= "{$option} <> ''";
				}
			}
		}

		if ($empty_only)
		{
			$profile_where .= ' ) ';
		}

		if (isset($options[$display]))
		{
			if ($empty_only)
			{
				$profile_where = ' AND ' . $display . ' <> \'\'';
			}
		}

		/*
		* Order stuff
		*/
		$order = array(
			'user_regdate'			=> 'JOINED',
			'username_clean'		=> 'USERNAME',
			'user_lastvisit'		=> 'LAST_VISIT',
			'user_lastpost_time'	=> 'LAST_POST',
			'user_warnings'			=> 'WARNINGS',
			'user_posts'			=> 'POSTS',
		);
		$timestamps = array('user_regdate', 'user_lastvisit', 'user_lastpost_time');

		foreach ($order as $option => $lang_key)
		{
			$template->assign_block_vars('order', array(
				'OPTION'	=> $option,
				'LANG'		=> $lang[$lang_key],
				'SELECTED'	=> ($order_by == $option) ? true : false,
			));
		}

		$order_sql = ' ORDER BY user_regdate DESC';
		if (isset($order[$order_by]))
		{
			$order_sql = ' ORDER BY ' . $order_by . ' ' . $order_dir;
		}
		else
		{
			$order_by = 'user_regdate';
		}

		/*
		* Main stuff...
		*/
		$sql = 'SELECT COUNT(u.user_id) as cnt
					FROM ' . USERS_TABLE . ' u '. $extra . '
			WHERE u.user_type <> ' . USER_IGNORE .
			$profile_where .
			$profile;

		$db->sql_query($sql);
		$count = $db->sql_fetchfield('cnt');

		$sql = 'SELECT u.user_id AS uid, u.username, u.user_sig, u.user_jabber, u.user_inactive_reason, u.user_email, u.user_regdate, u.user_posts, u.user_sig_bbcode_uid, u.user_sig_bbcode_bitfield, u.user_colour, u.user_lastvisit, u.user_warnings, u.user_lastpost_time, u.username_clean, p.*
			FROM ' . USERS_TABLE . ' AS u
			LEFT JOIN ' . PROFILE_FIELDS_DATA_TABLE . ' AS p ON (p.user_id = u.user_id)
			WHERE u.user_type <> ' . USER_IGNORE .
				$profile_where .
				$profile .
				$order_sql;

		$result = $db->sql_query_limit($sql, $limit, $start);
		while ($row = $db->sql_fetchrow($result))
		{
			$inactive_reason = $user->lang['INACTIVE_REASON_UNKNOWN'];
			switch ($row['user_inactive_reason'])
			{
				case INACTIVE_REGISTER:
					$inactive_reason = $user->lang['INACTIVE_REASON_REGISTER'];
				break;

				case INACTIVE_PROFILE:
					$inactive_reason = $user->lang['INACTIVE_REASON_PROFILE'];
				break;

				case INACTIVE_MANUAL:
					$inactive_reason = $user->lang['INACTIVE_REASON_MANUAL'];
				break;

				case INACTIVE_REMIND:
					$inactive_reason = $user->lang['INACTIVE_REASON_REMIND'];
				break;
			}

			$template_vars = array(
				'SKYPE'				=> $row['pf_phpbb_skype'],
				'FACEBOOK'			=> $row['pf_phpbb_facebook'],
				'YAHOO'				=> $row['pf_phpbb_yahoo'],
				'TWITTER'			=> $row['pf_phpbb_twitter'],
				'YOUTUBE' 			=> $row['pf_phpbb_youtube'],

				'EMAIL'				=> $row['user_email'],
				'ICQ'				=> $row['pf_phpbb_icq'],
				'INTERESTS'			=> $row['pf_phpbb_interests'],
				'JABBER'			=> $row['user_jabber'],
				'JOINED'			=> $user->format_date($row['user_regdate']),
				'LOCATION'			=> $row['pf_phpbb_location'],
				'OCCUPATION'		=> $row['pf_phpbb_occupation'],
				'POSTS'				=> $row['user_posts'],
				'SIGNATURE'			=> ((!isset($options[$display]) || $display == 'user_sig') && $row['user_sig']) ? generate_text_for_display($row['user_sig'], $row['user_sig_bbcode_uid'], $row['user_sig_bbcode_bitfield'], 7) : '',
				'USERID'			=> ($user->data['user_id'] == $row['uid']) ? false : $row['uid'],
				'USERNAME'			=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'VISITED'			=> ($row['user_lastvisit']) ? $user->format_date($row['user_lastvisit']) : 0,
				'WARNINGS'			=> $row['user_warnings'],
				'WEBSITE'			=> $row['pf_phpbb_website'],

				'OPTION_SECTION'		=> (isset($options[$display])) ? $row[$display] : '',
				'ORDER_SECTION'			=> (in_array($order_by, $timestamps)) ? (($row[$order_by]) ? $user->format_date($row[$order_by]) : $user->lang['NEVER']) : $row[$order_by],
				'USER_INACTIVE_REASON'	=> $inactive_reason,

				'U_USER_ADMIN'		=> append_sid(PHPBB_ROOT_PATH . 'adm/index.' . PHP_EXT, 'i=users&amp;mode=overview&amp;u=' . $row['uid'], true, $user->session_id),

				'S_USER_INACTIVE'	=> ($row['user_inactive_reason']) ? true : false,
			);

			if (version_compare(PHPBB_VERSION, '3.3.1', '<') && isset($row['pf_phpbb_googleplus']))
			{
				$template_vars = array_merge($template_vars, array(
					'AOL'		=> $row['pf_phpbb_aol'],
					'GOOGLE'	=> $row['pf_phpbb_googleplus'],
				));
			}

			$template->assign_block_vars('users', $template_vars);
		}
		$db->sql_freeresult($result);

		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $count, $limit, $start);

		$template->assign_vars(array(
			'U_DISPLAY_ACTION'		=> append_sid(STK_INDEX, 't=profile_list&amp;go=1'),
			'U_SELECTED_ACTION'		=> append_sid(STK_INDEX, array('c' => 'admin', 't' => 'profile_list', 'sa' => true)),

			'LIMIT'					=> $limit,
			'OPTION_SECTION'		=> (isset($options[$display]) && $display != 'user_sig') ? $user->lang[$options[$display]] : '',
			'ORDER_SECTION'			=> ($order_by == 'username_clean') ? '' : ((isset($order[$order_by])) ? $user->lang[$order[$order_by]] : $user->lang['JOINED']),
			'TOTAL_ITEMS'			=> '' . user_lang('TOTAL') . ': ' . $count . '',

			'S_DESC'				=> ($order_dir == 'DESC') ? true : false,
			'S_DISPLAY_ALL'			=> (!isset($options[$display])) ? true : false,
			'S_DISPLAY_SIG'			=> ($display == 'user_sig') ? true : false,
			'S_EMPTY_CHECKED'		=> $empty_only,
			'A_BASE_URL'			=> append_sid(STK_INDEX, array('c' => 'admin', 't' => 'profile_list', 'limit' => '' . $limit . '', 'go' => 1)),
		));

		$template->set_filenames(array(
			'body' => 'tools/profile_list.html',
		));

		page_footer();
	}
}
