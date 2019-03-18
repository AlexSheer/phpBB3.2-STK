<?php
/**
 *
 * @package Support Toolkit - Prune Styles
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

class prune_styles
{
	function display_options()
	{
		global $db, $template, $request, $lang;

		$submit = $request->variable('sa', false);
		$list = '';
		$styles = array();

		page_header(user_lang('PRUNE_STYLES'));

		if ($submit)
		{			$sql = 'SELECT style_id, style_name, style_path
				FROM ' . STYLES_TABLE . '';
			$result = $db->sql_query($sql);
			while ($data = $db->sql_fetchrow($result))
			{				$styles[] = array('style_id' => $data['style_id'], 'style_path' => $data['style_path'], 'style_name' => $data['style_name']);			}
			$db->sql_freeresult($result);
			$dir = '' . PHPBB_ROOT_PATH . 'styles/';
			foreach ($styles as $key => $value)
			{				if (!file_exists($dir . $value['style_path'] . '/style.cfg'))
				{
					$res = $this->delete_style($styles[$key]);
					if ($res === true)
					{						$list .= sprintf($lang['STYLE_UNINSTALL_SUCESS'], $styles[$key]['style_name']) . '<br />';					}
					else
					{						$list .= $res;
					}
				}
			}

			$message = ($list)? '' . user_lang('PRUNE_STYLES_SUCCESS') . '<br />' . $list . '' : user_lang('PRUNE_STYLES_EMPTY');
			meta_refresh(3, append_sid("" . STK_ROOT_PATH . "index." . PHP_EXT . "", 'c=admin'));
			trigger_error($message);
		}

		$template->assign_vars(array(
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, 't=prune_styles&amp;go=1'),
		));

		$template->set_filenames(array(
			'body' => 'tools/prune_styles.html',
		));

		page_footer();
	}

	function delete_style($style)
	{		global $db, $lang, $config;

		$id = $style['style_id'];
		$path = $style['style_path'];
		$default_style = $config['default_style'];

		// Check if style has child styles
		$sql = 'SELECT style_id
			FROM ' . STYLES_TABLE . '
			WHERE style_parent_id = ' . (int) $id . " OR style_parent_tree = '" . $db->sql_escape($path) . "'";
		$result = $db->sql_query($sql);

		$conflict = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($conflict !== false)
		{
			return sprintf($lang['STYLE_UNINSTALL_DEPENDENT'], $style['style_name']);
		}

		// Change default style for users
		$sql = 'UPDATE ' . USERS_TABLE . '
			SET user_style = ' . (int) $default_style . '
			WHERE user_style = ' . $id;
		$db->sql_query($sql);

		// Uninstall style
		$sql = 'DELETE FROM ' . STYLES_TABLE . '
			WHERE style_id = ' . $id;
		$db->sql_query($sql);

		$this->delete_files($path);
		return true;
	}

	function delete_files($path, $dir = '')
	{
		$styles_path = '' . PHPBB_ROOT_PATH . 'styles/';
		$dirname = $styles_path . $path . $dir;
		$result = true;

		$dp = @opendir($dirname);

		if ($dp)
		{
			while (($file = readdir($dp)) !== false)
			{
				if ($file == '.' || $file == '..')
				{
					continue;
				}
				$filename = $dirname . '/' . $file;
				if (is_dir($filename))
				{
					if (!$this->delete_files($path, $dir . '/' . $file))
					{
						$result = false;
					}
				}
				else
				{
					if (!@unlink($filename))
					{
						$result = false;
					}
				}
			}
			closedir($dp);
		}
		if (!@rmdir($dirname))
		{
			return false;
		}

		return $result;
	}
}
