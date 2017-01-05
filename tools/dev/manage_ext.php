<?php
/**
*
* @package Support Toolkit - extensions
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

class manage_ext
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		global $template, $user, $db, $config, $phpbb_root_path, $phpbb_extension_manager, $cache, $request;
		$error = array();
		$submit = $request->variable('sa', false);
		$mode = $request->variable('m', '');
		$save = $request->variable('save', false);
		$file = $request->variable('file', '');
		$path_new = $request->variable('path', '');
		$path = $request->variable('e', '');

		$ext = $request->variable('e', '');
		$content = $request->variable('template_data', '', true);
		$file_name = $request->variable('f', '');
		$name = $request->variable('n', '', true);

		$template->assign_vars(array(
			'U_BACK_TOOL'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'view', 'e' => $path, 'n' => $name)),
		));

		switch ($mode)
		{
			case 'rename':
				$new_file_name = $request->variable('newname', '');
				$fname = explode('/', $file_name);
				$old_file_name = $fname[max(array_keys($fname))];
				$ren_path = str_replace($old_file_name, '', $file_name);

				$template->assign_vars(array(
					'S_RENAME'	=> true,
					'FILE'		=> $old_file_name,
					'U_BACK_TOOL'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'view', 'e' => $path, 'n' => $name)),
					'S_ACTION'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'rename', 'e' => $path, 'f' => $file_name, 'n' => $name, 'save' => 1)),
				));

				if($save && !empty($new_file_name))
				{
					if(is_dir($file_name))
					{
						$new_file_rename = $ren_path.$new_file_name;
						$result = @rename ($file_name, $new_file_rename);
						$message = ($result) ? sprintf($user->lang['RENAME_FOLDER_OK'], $old_file_name, $new_file_name) : sprintf($user->lang['RENAME_FOLDER_FAIL'], $old_file_name);
					}
					else
					{
						$new_file_rename = $phpbb_root_path.$ren_path.$new_file_name;
						$result = @rename ($phpbb_root_path.$file_name, $new_file_rename);
						$message = ($result) ? sprintf($user->lang['RENAME_OK'], $old_file_name, $new_file_name) : sprintf($user->lang['RENAME_FAIL'], $old_file_name);
					}
					meta_refresh(3, append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'view', 'e' => $path, 'n' => $name)));
					trigger_error($message);
				}
			break;

			case 'delete':
				if(is_dir($file_name))
				{
					$result = $this->remove_directory($file_name);
					$message = ($result) ? sprintf($user->lang['DELETE_FOLDER_OK'], $file_name) : sprintf($user->lang['DELETE_FOLDER_FAIL'], $file_name);
				}
				else
				{
					$file_name = $phpbb_root_path.$file_name;
					$result = @unlink($file_name);
					$message = ($result) ? sprintf($user->lang['DELETE_OK'], $file_name) : sprintf($user->lang['DELETE_FAIL'], $file_name);
				}

				$template->assign_vars(array(
					'U_BACK_TOOL'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'view', 'e' => $name, 'n' => $path)),
				));
				meta_refresh(3, append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'view', 'e' => $name, 'n' => $path)));
				trigger_error($message);
			break;

			case 'new':
				$path = $phpbb_root_path.'ext/' . $ext . '/' . $path_new;
				if (!$handle = @opendir($path))
				{
					$result = @mkdir($path, 0777, true);
					if (!$result)
					{
						trigger_error(sprintf($user->lang['FAIL_CREATE_DIR'], $path_new), E_USER_WARNING);
					}
				}
				$file = str_replace('//', '/', $path .'/'. $file);
				if(file_exists($file))
				{
					trigger_error(sprintf($user->lang['FAIL_EXISTS'], $file), E_USER_WARNING);
				}
				$fp = @fopen($file, 'w');
				if(!$fp)
				{
					@fclose($fp);
					trigger_error(sprintf($user->lang['FAIL_CREATE_FILE'], $file), E_USER_WARNING);
				}
				fwrite($fp, htmlspecialchars_decode($content));
				fclose($fp);
				meta_refresh(3, append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'view', 'e' => $ext, 'n' => $name)));
				trigger_error(sprintf($user->lang['SAVED'], $file));
			break;

			case 'edit':
				$template->assign_block_vars('row', array());
				if($save)
				{
					$fp = fopen($phpbb_root_path.$file_name, 'w');
					fwrite($fp, htmlspecialchars_decode($content));
					fclose($fp);
					$cache->purge();
					meta_refresh(3, append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'view', 'e' => $ext, 'n' => $name)));
					trigger_error(sprintf($user->lang['EDITED'], $phpbb_root_path.$file_name));
				}

				$handle = fopen($phpbb_root_path.$file_name, 'r');
				if($handle)
				{
					$contents = (filesize($phpbb_root_path.$file_name)) ? fread($handle, filesize($phpbb_root_path.$file_name)) : '';
					fclose($handle);
				}

				$template->assign_vars(array(
					'S_EDIT'	=> true,
					'CONTENT'	=> $contents,
					'FILE'		=> $file_name,
					'S_ACTION'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'edit', 'f' => $file_name,  'e' => $ext, 'n' => $name, 'save' => 1)),
				));

			break;
			case 'view':
				global $list_dir_count, $filecount, $list, $exclude_paths, $exclude_ext, $root_dir_files, $root_dir_folders, $dirs;

				$dir = $phpbb_root_path . 'ext/' . $path;
				$list_dir_count = $filecount = 0;
				$dirs = $list = array();
				$exclude_paths = array('.', '..');
				$this->dir_count($dir, $exclude_paths);
				$exclude_ext = array('gif', 'jpg', 'jpeg', 'png');
				$root_dir_files = $this->root_dir_file_count($dir);
				$root_dir_folders = sizeof($dirs);

				$list = $this->list_dir($dir, 0);
				$reversed = array_reverse($list);
				$code = '';
				foreach($reversed as $item)
				{
					$code .= "\t\t$item\n";
					$template->assign_block_vars('row', array());
				}

				$template->assign_vars(array(
					'S_TREE'	=> true,
					'TREE'		=> $code,
					'ROOT'		=> 'ext/' .$path,
					'EXT_FILES'	=> $name,
					'L_PATH'	=> user_lang('PATH', $dir),
					'S_ACTION'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'new', 'f' => $file, 'e' => $path, 'n' => $name, 'save' => 1)),
				));
			break;

			default:
				$all = $phpbb_extension_manager->all_available();
				foreach ($phpbb_extension_manager->all_available() as $name => $location)
				{
					$md_manager = $phpbb_extension_manager->create_extension_metadata_manager($name, $template);
					try
					{
						$display_ext_name = $md_manager->get_metadata('display-name');
						$meta = $md_manager->get_metadata('all');
						$available_extension_meta_data[$name] = array(
							'IS_BROKEN'			=> false,
							'META_DISPLAY_NAME'	=> $display_ext_name,
							'META_NAME'			=> $name,
							'META_VERSION'		=> $meta['version'],
						);
					}
					catch(\phpbb\extension\exception $e)
					{
						$available_extension_meta_data[$name] = array(
							'IS_BROKEN'			=> true,
							'META_DISPLAY_NAME'	=> (isset($display_ext_name)) ? $display_ext_name : objects::$user->lang['EXTENSION_BROKEN'] . ' (' . $name . ')',
							'META_NAME'			=> $name,
							'META_VERSION'		=> (isset($meta['version'])) ? $meta['version'] : '0.0.0',
						);
					}
				}

				if(isset($available_extension_meta_data))
				{
					uasort($available_extension_meta_data, array('self', 'sort_extension_meta_data_table'));

					foreach ($available_extension_meta_data as $name => $block_vars)
					{
						$template->assign_block_vars('row', array(
							'EXT_PATH'		=> $name,
							'EXT_NAME'		=> $block_vars['META_DISPLAY_NAME'],
							'EXT_VERSION'	=> $block_vars['META_VERSION'],
							'S_ENABLED'		=> ($phpbb_extension_manager->is_enabled($name)) ? true : false,
							'S_DISABLED'	=> ($phpbb_extension_manager->is_disabled($name)) ? true : false,
							'U_EXT_NAME'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'view', 'e' => $name, 'n' => $block_vars['META_DISPLAY_NAME'])),
						));
					}
				}
			break;
		}

		// This is kinda like the main page
		// Output the main page
		page_header(user_lang('SUPPORT_TOOL_KIT'));

		$template->set_filenames(array(
			'body' => 'tools/manage_extensions_body.html',
		));

		page_footer();
	}

	function sort_extension_meta_data_table($val1, $val2)
	{
		return strnatcasecmp($val1['META_DISPLAY_NAME'], $val2['META_DISPLAY_NAME']);
	}

	function list_dir($path = '.', $parent = 0)
	{
		global $list_dir_count, $filecount, $list, $root_path, $exclude_paths, $exclude_ext, $root_dir_files, $root_dir_folders, $user, $request;
		$ext_name = $request->variable('n', '');
		$ext_path = $request->variable('e', '');

		$folders = array();
		$files = array();

		if ($handle = @opendir($path))
		{
			while (false !== ($file = readdir($handle)))
			{
				if (!in_array($file, $exclude_paths))
				{
					if (is_dir($path . '/' . $file))
					{
						$folders[] = $path . '/' . $file;
					}
					else
					{
						$files[] = $file;
					}
				}
			}

			$filecount = ($path == $root_path) ? $parent + $root_dir_folders : $list_dir_count + $root_dir_folders + $root_dir_files;

			for ($i = (count($files) - 1); $i >= 0; $i--)
			{
				$name = basename($files[$i]);
				$extension = substr($name, strrpos($name, '.') + 1);
				if (!in_array($extension, $exclude_ext))
				{
					$filecount++;
					$this_link = '' . $path . '/'. $name;
					$this_link = str_replace(PHPBB_ROOT_PATH, '', $this_link);

					$link = append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'edit', 'e' => $ext_path, 'n' => $ext_name, 'f' => '' . $this_link . ''));
					$rename = append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'rename', 'e' => $ext_path, 'n' => $ext_name, 'f' => '' . $this_link . ''));
					$del = append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'delete', 'e' => $ext_name, 'n' => $ext_path, 'f' => '' . $this_link . ''));

					$list[] = "d.add(" . $filecount . ", " . $parent . ", '" . $name . "', '" . $link . "', '" . $user->lang['EDIT'] . "', '', '', '', '', '" . $del . "', '" . $rename . "', '" . $user->lang['DELETE'] . "', '" . user_lang('RENAME') . "');";
				}
			}

			for ($i = (count($folders) - 1); $i >= 0; $i--)
			{
				$list_dir_count++;
				$filecount++;
				$rename = append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'rename', 'e' => $ext_path, 'n' => $ext_name, 'f' => '' . $path . '/' . basename($folders[$i]) . ''));
				$del = append_sid(STK_INDEX, array('c' => 'dev', 't' => 'manage_ext', 'm' => 'delete', 'e' => $ext_name, 'n' => $ext_path, 'f' => '' . $path . '/' . basename($folders[$i]) . ''));
				$list[] = "d.add(" . $list_dir_count . "," . $parent . ",'" . basename($folders[$i]) . "', '', '', '', 'images/folder.gif', '', '', '" . $del . "' , '" . $rename . "', '" . $user->lang['DELETE'] . "', '" . user_lang('RENAME') . "');";
				$this->list_dir($folders[$i], $list_dir_count);
			}
			closedir($handle);
		}
		return $list;
	}

	function dir_count($path, $exclude_paths)
	{
		global $dirs;
		foreach($exclude_paths as $ex)
		{
			$exclude[] = PHPBB_ROOT_PATH . '/' . $ex . '';
		}
		if (!in_array($path, $exclude))
		{
			$files = glob($path . '/*', GLOB_ONLYDIR);
			foreach($files as $dir)
			{
				$dirs[] = $dir;
				$this->dir_count($dir, $exclude_paths);
			}
		}
	}

	function root_dir_file_count($path)
	{
		$files = @scandir($path);
		$f_count = 0;
		if(!empty($files))
		{
			foreach($files as $unit)
			{
				if(!is_dir($unit))
				{
					$f_count++;
				}
			}
		}
		return $f_count;
	}

	function remove_directory($dir)
	{
		if ($objs = glob($dir."/*"))
		{
			foreach($objs as $obj)
			{
				is_dir($obj) ? $this->remove_directory($obj) : @unlink($obj);
			}
		}
		$result = @rmdir($dir);
		if (!$result)
		{
			return false;
		}
		return true;
	}
}
