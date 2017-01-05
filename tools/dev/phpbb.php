<?php
/**
*
* @package Support Toolkit - PHPBB
* @version $Id$
* @copyright (c) 2015 Sheer phpbbguru.net
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

class phpbb
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		global $template, $user, $request;
		$file_name = $request->variable('f', '');

		page_header(user_lang('SUPPORT_TOOL_KIT'));
		$dir = PHPBB_ROOT_PATH;

		if($file_name)
		{
			$template->assign_vars(array(
				'S_CONTENTS'	=> true,
				'FILE_NAME'		=> $file_name,
			));

			$file_name = ''. $dir . '' . $file_name . '';
			$handle = @fopen($file_name, 'r');
			if($handle)
			{
				$contents = (filesize($file_name)) ? fread($handle, filesize($file_name)) : '';
				fclose($handle);
			}
			else
			{
				trigger_error($user->lang['FILE_NOT_FOUND']);
			}

			$template->assign_vars(array(
				'TEXT'	=> ($contents) ? str_replace('</textarea>', '&lt;/textarea&gt;', $contents) : '',
			));
		}
		else
		{
			$time_start = $this->microtime_float();
			global $list_dir_count, $filecount, $list, $root_path, $exclude_paths, $exclude_ext, $root_dir_files, $root_dir_folders, $dirs;
			$list_dir_count = $filecount = 0;
			$dirs = $list = array();
			$root_path = $dir;
			$exclude_paths = array('.', '..', 'vendor', 'stk',);
			$this->dir_count($root_path, $exclude_paths);
			$exclude_ext = array('gif', 'jpg', 'jpeg', 'png');
			$root_dir_files = $this->root_dir_file_count($root_path);
			$root_dir_folders = sizeof($dirs);

			$list = $this->list_dir($root_path);
			$reversed = array_reverse($list);
			$code = '';
			foreach($reversed as $item)
			{
				$code .= "\t\t$item\n";
			}

			$template->assign_vars(array(
				'TREE'	=> $code,
				'ROOT'	=> user_lang('ROOT'),
				'TIME'	=> user_lang('G_TIME', $this->microtime_float() - $time_start),
			));
		}

		$template->set_filenames(array(
			'body' => 'tools/phpbb_body.html',
		));

		page_footer();
	}

	function list_dir($path = '.', $parent = 0)
	{
		global $list_dir_count, $filecount, $list, $root_path, $exclude_paths, $exclude_ext, $root_dir_files, $root_dir_folders;

		$folders = array();
		$files = array();

		if ($handle = opendir($path))
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
					$link = append_sid(STK_INDEX, array('c' => 'dev', 't' => 'phpbb', 'f' => '' . $this_link . ''));
					$list[] = "d.add(" . $filecount . "," . $parent . ",'" . $name . "','" . $link . "');";
				}
			}

			for ($i = (count($folders) - 1); $i >= 0; $i--)
			{
				$list_dir_count++;
				$filecount++;
				$list[] = "d.add(" . $list_dir_count . "," . $parent . ",'" . basename($folders[$i]) . "','','','','images/folder.gif');";
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
		$files = scandir($path);
		$f_count = 0;
		foreach($files as $unit)
		{
			if(!is_dir($unit))
			{
				$f_count++;
			}
		}
		return $f_count;
	}

	function microtime_float()
	{
		list($usec, $sec) = explode(' ', microtime());
		return ((float)$usec + (float)$sec);
	}
}
