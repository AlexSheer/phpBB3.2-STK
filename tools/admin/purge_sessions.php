<?php
/**
*
* @package Support Toolkit - Purge Sessions
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

class purge_sessions
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		if (@phpversion() < '7.0.0')
		{
			return 'PURGE_SESSIONS';
		}

		global $lang;

		if (confirm_box(true))
		{
			$this->run_tool();
		}
		else
		{
			confirm_box(false, user_lang('PURGE_SESSIONS_CONFIRM'), '', 'confirm_body.html', STK_DIR_NAME . '/index.' . PHP_EXT . '?c=admin&amp;t=purge_sessions&amp;submit=' . true);
		}
	}

	/**
	* Run Tool
	*
	* Does the actual stuff we want the tool to do after submission
	*/
	function run_tool()
	{
		global $db, $user;

		$tables = array(CONFIRM_TABLE, SESSIONS_TABLE, SESSIONS_KEYS_TABLE);
		foreach ($tables as $table)
		{
			$db->sql_query("DELETE FROM $table");
		}

		// Restore the current admin session
		$sql_ary = array(
			'session_id'			=> (string) $user->session_id,
			'session_user_id'		=> (int) $user->data['user_id'],
			'session_start'			=> (int) $user->time_now,
			'session_last_visit'	=> (int) $user->data['session_last_visit'],
			'session_time'			=> (int) $user->time_now,
			'session_browser'		=> (string) trim(substr($user->browser, 0, 149)),
			'session_forwarded_for'	=> (string) $user->forwarded_for,
			'session_page'			=> (string) substr($user->page['page'], 0, 199),
			'session_ip'			=> (string) $user->ip,
			'session_autologin'		=> (int) $user->data['session_autologin'],
			'session_admin'			=> 1,
			'session_viewonline'	=> (int) $user->data['session_viewonline'],
		);

		$sql_ary['session_forum_id'] = $user->page['forum'];

		$sql = 'INSERT INTO ' . SESSIONS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
		$db->sql_query($sql);

		trigger_error(user_lang('PURGE_SESSIONS_COMPLETE'));
	}
}
