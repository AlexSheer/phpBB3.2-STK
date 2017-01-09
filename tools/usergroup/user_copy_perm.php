<?php
/**
*
* @package Support Toolkit - User Options
* @version $Id$
* @copyright (c) 2015 phpBB Group
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

class user_copy_perm
{
	function display_options()
	{
		global $template, $user, $db, $request;

		$submit = $request->variable('sa', false);
		$source_name = $request->variable('source_name', '', true);
		$target_name = $request->variable('target_name', '', true);
		$source_id = $request->variable('source_id', '');
		$target_id = $request->variable('target_id', '');

		if ($submit)
		{
			// Check that at least one field is filled in.
			if (!$source_name && empty($source_id) || !$target_name && empty($target_id))
			{
				trigger_error('NO_USER', E_USER_WARNING);
			}

			// Not allowed to have both username and user_id filled.
			if (($source_name && $source_id) || ($target_name && $target_id))
			{
				trigger_error(user_lang('BOTH_FIELDS_FILLED'), E_USER_WARNING);
			}

			if ($source_name && empty($source_id))
			{
				// Get the correct user data and make sure that he exists
				if (!function_exists('user_get_id_name'))
				{
					include (PHPBB_ROOT_PATH . 'includes/functions_user.' . PHP_EXT);
				}
				$result = user_get_id_name($source_id, $source_name);
				// Was a user_id found?
				if (!sizeof($source_id) || $result !== false)
				{
					trigger_error('NO_USER', E_USER_WARNING);
				}

				// Drop the arrays
				$source_id = array_shift($source_id);
				$source_name = array_shift($source_name);

				$result = user_get_id_name($target_id, $target_name);
				// Was a user_id found?
				if (!sizeof($target_id) || $result !== false)
				{
					trigger_error('NO_USER', E_USER_WARNING);
				}

				// Drop the arrays
				$target_id = array_shift($target_id);
				$target_name = array_shift($target_name);
			}

			if (($target_id == $source_id) || ($source_name == $target_name))
			{
				trigger_error(user_lang('USERS_IDENTICAL'), E_USER_WARNING);
			}

			$permissions = array();

			$sql = 'SELECT forum_id, auth_option_id, auth_role_id, auth_setting
				FROM ' . ACL_USERS_TABLE . '
				WHERE user_id = ' . $source_id;
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				$row['user_id'] = $target_id;
				$permissions[] = $row;
			}
			$db->sql_freeresult($result);

			$sql = 'SELECT user_permissions
				FROM ' . USERS_TABLE . '
				WHERE user_id = '. $source_id . '
				AND user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')';
			$result = $db->sql_query($sql);
			$user_permissions = $db->sql_fetchfield('user_permissions');
			$db->sql_freeresult($result);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_permissions = \'' . $user_permissions . '\'
				WHERE user_id = '. $target_id;
			$db->sql_query($sql);

			if (sizeof($permissions))
			{
				$sql = 'DELETE FROM ' . ACL_USERS_TABLE . '
					WHERE user_id = '. $target_id .'';
				$db->sql_query($sql);

				foreach($permissions as $key => $data_sql)
				{
					$sql = 'INSERT INTO ' . ACL_USERS_TABLE . ' ' . $db->sql_build_array('INSERT', $data_sql);
					$db->sql_query($sql);
				}
			}

			trigger_error(user_lang('COPY_USER_PERMISSIONS_OK'));
		}

		$template->assign_vars(array(
			'SOURCE_NAME'		=> $source_name,
			'SOURCE_ID'			=> $source_id,
			'TARGET_NAME'		=> $target_name,
			'TARGED_ID'			=> $target_id,
			'U_FIND_USER'		=> append_sid(PHPBB_ROOT_PATH . 'memberlist.' . PHP_EXT, array('mode' => 'searchuser', 'form' => 'stk', 'field' => 'source_name')),
			'U_FIND_TO_USER'	=> append_sid(PHPBB_ROOT_PATH . 'memberlist.' . PHP_EXT, array('mode' => 'searchuser', 'form' => 'stk', 'field' => 'target_name')),
		));

		$template->set_filenames(array(
			'body' => 'tools/user_copy_perm.html',
		));

		page_header(user_lang('USER_COPY_PERM'), false);
		page_footer();
	}
}
