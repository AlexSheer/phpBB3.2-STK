<?php
/**
*
* @package Support Toolkit - Delete users
* @version $Id$
* @copyright (c) 2010 phpBB Group
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

class delete_users
{
	function run_tool(&$error)
	{
		global $user, $db, $request;

		// Try to override some limits - maybe it helps some...
		@set_time_limit(0);
		$mem_limit = @ini_get('memory_limit');
		if (!empty($mem_limit))
		{
			$unit = strtolower(substr($mem_limit, -1, 1));
			$mem_limit = (int) $mem_limit;

			if ($unit == 'k')
			{
				$mem_limit = floor($mem_limit / 1024);
			}
			else if ($unit == 'g')
			{
				$mem_limit *= 1024;
			}
			else if (is_numeric($unit))
			{
				$mem_limit = floor((int) ($mem_limit . $unit) / 1048576);
			}
			$mem_limit = max(128, $mem_limit) . 'M';
		}
		else
		{
			$mem_limit = '128M';
		}
		@ini_set('memory_limit', $mem_limit);

		$period = $request->variable('period', 0);
		$message = user_lang('DELETE_USERS_NOT_FOUND');
		$inactive_time = time() - 86400 * $period;

		$sql = 'SELECT group_id
			FROM ' . GROUPS_TABLE . '
				WHERE group_name LIKE \'BOTS\'
					OR group_name LIKE \'ADMINISTRATORS\' OR group_name LIKE \'GUESTS\'';
		$db->sql_query($sql);
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$exclude_groups[] = $row['group_id'];
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT user_id
			FROM ' . USERS_TABLE . '
			WHERE user_regdate <= ' . $inactive_time . '
				AND user_posts = 0 AND '. $db->sql_in_set('group_id', $exclude_groups, true) . ' AND user_lastvisit < ' . $inactive_time;
		$db->sql_query($sql);
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$uids[] = $row['user_id'];
		}
		$db->sql_freeresult($result);

		if(!empty($uids))
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
			$message = user_lang('DELETE_USERS_SUCESS');
		}
		meta_refresh(3, append_sid(STK_ROOT_PATH . 'index.' . PHP_EXT, 'c=usergroup&amp;t=delete_users'));
		trigger_error($message);
	}

	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		global $template, $lang, $request, $user;

		$user->add_lang('memberlist');

		$delete = $request->variable('delete', false);
		$period = $request->variable('period', 3);

		$period_ary = array(0 => $lang['7_DAYS'], 1 => $lang['1_MONTH'], 2 => $lang['3_MONTHS'], 3 => $lang['6_MONTHS'], 4 => $lang['1_YEAR']);
		$times = array(0 => 7, 1 => 30, 2 => 90, 3 => 180, 4 => 365);
		$s_options = '';
		foreach($period_ary as $key => $value)
		{
			$selected = ($period == $key) ? ' selected="selected"' : '';
			$s_options .= '<option value="' . $times[$key]  . '"' . $selected . '>' . $period_ary[$key];
		}
		$s_options .= '</option>';

		$template->assign_vars(array(
			'S_PERIOD_SELECT'	=> $s_options,
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, array('c' => 'user_group', 't' => 'delete_users')),
		));

		if($delete)
		{
			if (confirm_box(true))
			{
			}
			else
			{
				$hidden = build_hidden_fields(array('period' => $period));
				confirm_box(false, user_lang('DELETE_USERS_CONFIRM'), $hidden, 'confirm_body.html', STK_DIR_NAME . '/index.' . PHP_EXT . '?c=user_group&amp;t=delete_users&amp;submit=' . true);
			}
		}
		page_header(user_lang('DELETE_USERS'));

		$template->set_filenames(array(
			'body' => 'tools/delete_users.html',
		));

		page_footer();
	}
}
