<?php
/**
 *
 * @package Support Toolkit - Delete Styles
 * @copyright (c) 2019 phpBBGuru Sheer
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

class delete_styles
{
	function display_options()
	{
		global $db, $template, $request, $lang, $config;

		$submit = $request->variable('sa', false);
		$list = '';

		page_header(user_lang('DELETE_STYLES'));

		if ($submit)
		{			// Check prosilver installed
			$style = 'prosilver';			$sql = 'SELECT style_id, style_name, style_path
				FROM ' . STYLES_TABLE . '
				WHERE style_name LIKE \'' . $style . '\'';
			$result = $db->sql_query($sql);
			while ($data = $db->sql_fetchrow($result))
			{
				$style_id = $data['style_id'];
				$style_path = $data['style_path'];
				$style_name = $data['style_name'];
			}
			$db->sql_freeresult($result);
			$dir = '' . PHPBB_ROOT_PATH . 'styles/';

			if (!$style_id)
			{
				// Install prosilver
				if (!file_exists($dir . 'prosilver/style.cfg'))
				{
					trigger_error($lang['NOT_EXISTS_ PROSILVER'], E_USER_WARNING);
				}

				$sql_ary = array(
					'style_name'		=> 'prosilver',
					'style_copyright'	=> '&copy; phpBB Limited',
					'style_active'		=> true,
					'style_path'		=> 'prosilver',
					'bbcode_bitfield'	=> "//g=",
					'style_parent_id'	=> 0,
					'style_parent_tree'	=> '',
				);
				$sql = 'INSERT INTO ' . STYLES_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				$db->sql_query($sql);
				$style_id = $db->sql_nextid();
			}

			$config->set('default_style', $style_id);

			$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_style = ' . $style_id);

			if ($style_id == $config['default_style'])
			{				if (!file_exists($dir . $style_path . '/style.cfg'))
				{					trigger_error('Not exists'. $style_name);
				}
			}
			// Delete styles
			$sql = 'SELECT style_id, style_name, style_path
				FROM ' . STYLES_TABLE . '
				WHERE style_id <> ' . $config['default_style'];
			$result = $db->sql_query($sql);
			while ($data = $db->sql_fetchrow($result))
			{
				$style = array('style_id' => $data['style_id'], 'style_path' => $data['style_path'], 'style_name' => $data['style_name']);
				$res = delete_style($style);
				if ($res === true)
				{
					$list .= sprintf($lang['STYLE_UNINSTALL_SUCESS'], $data['style_name']) . '<br />';
				}
				else
				{
					$list .= $res;
				}
			}
			$message = ($list)? '' . user_lang('PRUNE_STYLES_SUCCESS') . '<br />' . $list . '' : user_lang('DELETE_STYLES_EMPTY');

			meta_refresh(3, append_sid("" . STK_ROOT_PATH . "index." . PHP_EXT . "", 'c=admin'));
			trigger_error($message);
		}

		$template->assign_vars(array(
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, 't=delete_styles&amp;go=1'),
		));

		$template->set_filenames(array(
			'body' => 'tools/delete_styles.html',
		));

		page_footer();
	}
}
