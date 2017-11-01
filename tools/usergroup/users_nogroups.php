<?php
/**
*
* @package Support Toolkit - Users without groups
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

/*
* The class name MUST be the same as the filename (minus .PHP_EXT)
*/
class users_nogroups
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{		global $db, $template;

		$sql = 'SELECT user_id, username, user_colour
			FROM ' . USERS_TABLE . '
				WHERE user_id NOT IN(SELECT user_id FROM ' . USER_GROUP_TABLE . ')';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{			if ($row['user_id'] == 1)
			{				$sql = 'INSERT INTO ' . USER_GROUP_TABLE . ' (group_id, user_id, group_leader, user_pending) VALUES (1, 1, 0, 0)';
				$db->sql_query($sql);
			}
			else
			{
				$template->assign_block_vars('users', array(
					'L_USER_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
					'USER_ID'		=> $row['user_id'],
				));
			}
		}
		$db->sql_freeresult($result);

		// Additional template stuff
		$template->assign_vars(array(
			'U_ASSIGHN_GROUPS'	=> append_sid(STK_INDEX, array('c' => 'user_group', 't' => 'users_nogroups', 'mode' => 'demote', 'submit' => 1)),
			'S_GROUPS'			=> get_groups(),
		));

		$template->set_filenames(array(
			'body' => 'tools/users_nogroups.html',
		));

		page_header(user_lang('USERS_NOGROUPS'), false);
		page_footer();
	}

	/**
	* Run Tool
	*
	*/

	function run_tool()
	{		global $lang, $request;

		if (!check_form_key('users_nogroups'))
		{
			trigger_error('FORM_INVALID');
		}

		$users = $request->variable('users', array(0));

		if (empty($users))
		{			trigger_error($lang['NO_USERS_SELECTED'], E_USER_WARNING);
		}

		include(PHPBB_ROOT_PATH . 'includes/functions_user.' . PHP_EXT);

		// Collect the groups data
		$groups = array(
			'default'	=> $request->variable('defaultgroup', 0),
			'groups'	=> $request->variable('usergroups', array(0)),
		);

		foreach ($users as $user_id => $usr)
		{			foreach ($groups['groups'] as $group_id)
			{				$default = $leader = false;

				if ($groups['default'] == $group_id)
				{
					$default = true;
				}

				// Add to the group
				if (($msg = group_user_add($group_id, array($user_id), false, false, $default, $leader)) !== false)
				{
					// Something went wrong
					$error[] = $msg;
					return false;
				}
			}
		}		trigger_error($lang['ASSIGHN_GROUPS_SUCCESS']);
	}
}
