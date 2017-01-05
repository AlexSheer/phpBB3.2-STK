<?php
/**
*
* @package Support Toolkit - Clear Extensions
* @version $Id$
* @copyright (c) 2016 Sheer
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

class clear_black_list
{
	function display_options()
	{
		global $db, $template, $user, $cache, $request, $lang;

		$user->add_lang(array('acp/ban', 'acp/users'));
		$submit = $request->variable('sa', false);
		$ban = $request->variable('unban', array(''));
		$mode = 'ip';

		$form_key = 'clear_black_list';
		add_form_key($form_key);

		if ($submit)
		{
			if (!check_form_key($form_key))
			{
				trigger_error($user->lang['FORM_INVALID'], E_USER_WARNING);
			}
			if (!function_exists('user_ban'))
			{
				include(PHPBB_ROOT_PATH . 'includes/functions_user.' . PHP_EXT);
			}
			if ($ban)
			{
				user_unban($mode, $ban);

				trigger_error($user->lang['BAN_UPDATE_SUCCESSFUL']);
			}
		}

		// Ban length options
		$ban_end_text = array(0 => $user->lang['PERMANENT'], 30 => $user->lang['30_MINS'], 60 => $user->lang['1_HOUR'], 360 => $user->lang['6_HOURS'], 1440 => $user->lang['1_DAY'], 10080 => $user->lang['7_DAYS'], 20160 => $user->lang['2_WEEKS'], 40320 => $user->lang['1_MONTH'], -1 => $user->lang['UNTIL'] . ' -&gt; ');
		$ban_end_options = '';
		foreach ($ban_end_text as $length => $text)
		{
			$ban_end_options .= '<option value="' . $length . '">' . $text . '</option>';
		}
		$sql = 'SELECT *
			FROM ' . BANLIST_TABLE . '
			WHERE (ban_end >= ' . time() . "
					OR ban_end = 0)
				AND ban_ip <> ''
			ORDER BY ban_ip";
		$result = $db->sql_query($sql);

		$banned_options = $excluded_options = array();
		$field = 'ban_ip';
		while ($row = $db->sql_fetchrow($result))
		{
			$option = '<option value="' . $row['ban_id'] . '">' . $row[$field] . '</option>';

			if ($row['ban_exclude'])
			{
				$excluded_options[] = $option;
			}
			else
			{
				$banned_options[] = $option;
			}

			$time_length = ($row['ban_end']) ? ($row['ban_end'] - $row['ban_start']) / 60 : 0;

			if ($time_length == 0)
			{
				// Banned permanently
				$ban_length = $user->lang('PERMANENT');
			}
			else if (isset($ban_end_text[$time_length]))
			{
				// Banned for a given duration
				$ban_length = $user->lang('BANNED_UNTIL_DURATION', $ban_end_text[$time_length], $user->format_date($row['ban_end'], false, true));
			}
			else
			{
				// Banned until given date
				$ban_length = $user->lang('BANNED_UNTIL_DATE', $user->format_date($row['ban_end'], false, true));
			}

			$template->assign_block_vars('bans', array(
				'BAN_ID'		=> (int) $row['ban_id'],
				'LENGTH'		=> $ban_length,
				'A_LENGTH'		=> addslashes($ban_length),
				'REASON'		=> $row['ban_reason'],
				'A_REASON'		=> addslashes($row['ban_reason']),
				'GIVE_REASON'	=> $row['ban_give_reason'],
				'A_GIVE_REASON'	=> addslashes($row['ban_give_reason']),
			));
		}
		$db->sql_freeresult($result);

		$options = '';
		if ($excluded_options)
		{
			$options .= '<optgroup label="' . $user->lang['OPTIONS_EXCLUDED'] . '">';
			$options .= implode('', $excluded_options);
			$options .= '</optgroup>';
		}

		if ($banned_options)
		{
			$options .= '<optgroup label="' . $user->lang['OPTIONS_BANNED'] . '">';
			$options .= implode('', $banned_options);
			$options .= '</optgroup>';
		}

		$template->assign_vars(array(
			'S_BAN_END_OPTIONS'	=> $ban_end_options,
			'S_BANNED_OPTIONS'	=> ($banned_options || $excluded_options) ? true : false,
			'BANNED_OPTIONS'	=> $options,
		));

		page_header($lang['CLEAR_BLACK_LIST']);


		$template->assign_vars(array(
			'S_ACTION'		=> append_sid("" . STK_ROOT_PATH . "index." . PHP_EXT . "", 'c=admin&amp;t=clear_black_list'),
		));

		$template->set_filenames(array(
			'body' => 'tools/clear_black_list.html',
		));

		page_footer();
	}

}
