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

class user_options
{
	function display_options()
	{
		global $template, $lang, $db, $request;

		$settings_value = $request->variable('settings', array('' => ''), true);
		$groups = $request->variable('user_groups', array(0));
		$all_groups = $request->variable('all_groups', 0);
		$submit = $request->variable('sa', false);

		$user_settings = array(
			0 => 'viewimg',
			1 => 'viewflash',
			2 => 'viewsmilies',
			3 => 'viewsigs',
			4 => 'viewavatars',
			5 => 'viewcensors',
			6 => 'attachsig',
			7 => '',
			8 => 'bbcode',
			9 => 'smilies',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => 'sig_bbcode',
			16 => 'sig_smilies',
			17 => 'sig_links',
		);

		$sql = 'SELECT group_id, group_name
			FROM ' . GROUPS_TABLE;
		$result = $db->sql_query($sql);
		$s_options = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$group_name = (isset($lang['G_' . $row['group_name'] . ''])) ? $lang['G_' . $row['group_name'] . ''] : $row['group_name'];
			$s_options .= '<option value="' . $row['group_id'] . '">' . $group_name;
		}
		$db->sql_freeresult($result);
		$s_options .= '</option>';

		foreach ($user_settings as $bit => $settings)
		{
			if ($settings)
			{
				$template->assign_block_vars('settings', array(
					'SETTINGS'		=> $settings,
					'BIT'			=> $bit,
					'SETTINGS_NAME'	=> user_lang($settings),
				));
			}
		}

		$template->assign_vars(array(
			'S_OPTIONS'			=> $s_options,
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, array('c' => 'user_group', 't' => 'user_options')),
		));

		$template->set_filenames(array(
			'body' => 'tools/user_options.html',
		));

		if ($submit)
		{
			if (!sizeof($groups) || $all_groups)
			{
				$sql_where = '';
			}
			else
			{
				$sql_where = ' WHERE ' . $db->sql_in_set('group_id', $groups). '';
			}
			foreach ($settings_value as $bit => $settings)
			{
				if ($settings)
				{
					if ($settings == 1) // off
					{
						$sql = 'UPDATE '. USERS_TABLE . '
							SET user_options = (user_options & '. pow(2, $bit) . ') ^ user_options'
							. $sql_where;
					}
					else // on
					{
						$sql = 'UPDATE '. USERS_TABLE . '
							SET user_options = user_options | '. pow(2, $bit) . ''
							. $sql_where;
					}
					$db->sql_query($sql);
				}
			}

			meta_refresh(3, append_sid(STK_ROOT_PATH . 'index.' . PHP_EXT, 'c=usergroup&amp;t=user_options'));
			trigger_error(user_lang('USER_OPTIONS_OK'));
		}

		page_header(user_lang('USER_OPTIONS'), false);
		page_footer();
	}
}
