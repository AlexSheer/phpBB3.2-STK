<?php
/**
*
* @package Support Toolkit - Reclean Usernames
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

class reclean_usernames
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		return 'RECLEAN_USERNAMES';
	}

	/**
	* Run Tool
	*
	* Does the actual stuff we want the tool to do after submission
	*/
	function run_tool()
	{
		global $db, $template, $user, $phpbb_root_path, $phpEx, $request;

		$part = $request->variable('part', 0);
		$limit = 500;
		$i = 0;

		$sql = 'SELECT user_id, username, username_clean
			FROM ' . USERS_TABLE;
		$result = $db->sql_query_limit($sql, $limit, ($part * $limit));
		while ($row = $db->sql_fetchrow($result))
		{
			$i++;
			$username_clean = $db->sql_escape(utf8_clean_string($row['username']));

			if ($username_clean != $row['username_clean'])
			{
				$sql = 'SELECT user_id, username, username_clean
					FROM ' . USERS_TABLE . '
						WHERE username_clean LIKE \'' . $username_clean . '\'';
				$res = $db->sql_query_limit($sql, 1);
				$duplicate = $db->sql_fetchrow($res);
				$db->sql_freeresult($res);

				if (!empty($duplicate ))
				{
					$url = append_sid("{$phpbb_root_path}adm/index.$phpEx", 'i=users&amp;mode=overview&amp;u=' . $duplicate['user_id'] . '&amp;sid='. $user->data['session_id']);
					$problem = append_sid("{$phpbb_root_path}adm/index.$phpEx", 'i=users&amp;mode=overview&amp;u=' . $row['user_id'] . '&amp;sid='. $user->data['session_id']);
					trigger_error(sprintf($user->lang['USER_ALREADY_EXISTS'], $duplicate['username'], $url, $row['username'], $problem), E_USER_WARNING);
				}

				$db->sql_query('UPDATE ' . USERS_TABLE . " SET username_clean = '$username_clean' WHERE user_id = {$row['user_id']}");
			}
		}
		$db->sql_freeresult($result);

		if ($i == $limit)
		{
			meta_refresh(0, append_sid(STK_INDEX, 't=reclean_usernames&amp;submit=1&amp;part=' . (++$part)));
			$template->assign_var('U_BACK_TOOL', false);

			trigger_error(user_lang('RECLEAN_USERNAMES_NOT_COMPLETE'));
		}
		else
		{
			trigger_error(user_lang('RECLEAN_USERNAMES_COMPLETE'));
		}
	}
}
