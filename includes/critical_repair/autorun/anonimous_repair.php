<?php
/**
*
* @package Support Toolkit
* @version $Id$
* @copyright (c) 2015 Sheer
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

class erk_anonimous_repair
{
	function run()
	{
		global $config, $db;


		$sql = 'SELECT *
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . ANONYMOUS;
		$result = $db->sql_query($sql);
		$data = $db->sql_fetchrow($result);
		if (empty($data))
		{
			// Anonymous appear to be broken.  Attempt automatic repair
			$this->repair();
		}
		$db->sql_freeresult($result);
		return true;
	}

	function repair()
	{
		global $config, $db;

		$sql = 'SELECT group_id, group_rank, group_colour
			FROM ' . GROUPS_TABLE . "
			WHERE group_name = 'GUESTS'";
		$result	= $db->sql_query_limit($sql, 1, 0);
		$group_id		= $db->sql_fetchfield('group_id', false, $result);
		$group_rank		= $db->sql_fetchfield('group_rank', 0, $result);
		$group_colour	= $db->sql_fetchfield('group_colour', 0, $result);
		$db->sql_freeresult($result);

		$clean_data = array(
			'user_id'					=> ANONYMOUS,
			'user_type'					=> USER_IGNORE,
			'group_id'					=> $group_id,
			'username'					=> 'Anonymous',
			'username_clean'			=> 'anonymous',
			'user_regdate'				=> $config['board_startdate'],
			'user_password'				=> '',
			'user_email'				=> '',
			'user_lang'					=> $config['default_lang'],
			'user_style'				=> $config['default_style'],
			'user_rank'					=> $group_rank,
			'user_colour'				=> $group_colour,
			'user_timezone'				=> $config['board_timezone'],
			'user_dateformat'			=> $config['default_dateformat'],
			'user_options'				=> '230271',
			'user_posts'				=> 0,
			'user_permissions'			=> '',
			'user_ip'					=> '',
			'user_lastpage'				=> '',
			'user_last_confirm_key'		=> '',
			'user_topic_show_days'		=> 0,
			'user_post_sortby_type'		=> 't',
			'user_post_sortby_dir'		=> 'a',
			'user_topic_sortby_type'	=> 't',
			'user_topic_sortby_dir'		=> 'd',
			'user_avatar'				=> '',
			'user_sig'					=> '',
			'user_sig_bbcode_uid'		=> '',
			'user_new'					=> 1,
			'user_newpasswd'			=> '',
			'user_allow_massemail'		=> 0,
		);
		// Lets re-create the anonymous user
		$sql = 'INSERT INTO ' . USERS_TABLE . '
			' . $db->sql_build_array('INSERT', $clean_data);
		$db->sql_query($sql);
	}
}
