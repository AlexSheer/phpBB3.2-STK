<?php
/**
 *
 * @package Support Toolkit - Prune Attachments
 * @copyright (c) 2015 phpBBGuru Sheer
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

/**
 * Make sure that all attachments files on the database
 */
class prune_attachments
{
	/**
	 * The number of files
	 * @var Integer
	 */
	var $_batch_size = 500;

	function display_options()
	{
		global $db, $template, $config, $cache, $request;
		$list = '';
		// For further use if make extension "Attachments in subfolders"
		$subfolders = false;
		//

		$submit = $request->variable('sa', false);

		if ($submit)
		{
			$files = $bd_files = $delete_list = $unsuccess = array();

			ignore_user_abort(true);
			set_time_limit(0);

			$dir = '' . PHPBB_ROOT_PATH . '' . $config['upload_path'];
			$files_list = $cache->get('_stk_prune_attachments'); // Try get data from cache
			if(!$files_list)
			{
				// No data in cache
				$files = scan($dir, $files);
				$sql = 'SELECT attach_id, physical_filename
					FROM ' . ATTACHMENTS_TABLE;
				$result = $db->sql_query($sql);

				while($data = $db->sql_fetchrow($result))
				{
					if($subfolders)
					{
						// Attachments in subfolders
						$ais_folder_1 = substr(substr($data['attach_id'] + 1000000, -6), 0, 2);
						$ais_folder_2 = substr(substr($data['attach_id'] + 1000000, -4), 0, 2);
						$ais_path_to_add = '/' . $ais_folder_1 . '/' . $ais_folder_2;
						$bd_files[] = $dir . $ais_path_to_add . '/' . $data['physical_filename'];
						$bd_files[] = $dir . $ais_path_to_add . '/' .  'thumb_' . $data['physical_filename'];
					}
					else
					{
						$bd_files[] = $dir . '/' . $data['physical_filename'];
						$bd_files[] = $dir . '/' . 'thumb_' . $data['physical_filename'];
					}
				}
				$db->sql_freeresult($result);
				$files = array_diff($files, $bd_files);
				array_unique($files);
				array_map('trim', $files);
				sort($files);
				$cache->put('_stk_prune_attachments', $files);
			}
			else
			{
				$files = $files_list;
			}

			$count = 0;
			foreach ($files as $del_file)
			{
				if (file_exists($del_file) && !is_dir($del_file))
				{
					if (@unlink($del_file))
					{
						$delete_list[] = $del_file;
					}
					else
					{
						$unsuccess[] = $del_file;
					}

					$files = array_diff($files, array($del_file));

					sort($files);
					$count++;
				}
				if($count > ($this->_batch_size - 1))
				{
					$cache->destroy('_stk_prune_attachments');
					$cache->put('_stk_prune_attachments', $files);
					break;
				}
			}

			if(sizeof($delete_list))
			{
				$list .= implode('<br />', $delete_list);
				$exit = false;
			}
			else
			{
				$list = (sizeof($unsuccess)) ? '' : user_lang('PRUNE_ATTACHMENTS_FINISHED');
				$exit = true;
			}

			if(sizeof($unsuccess))
			{
				$list .= '' . user_lang('PRUNE_ATTACHMENTS_FAIL') . '<br />' . implode('<br />', $unsuccess) . '';
			}

			if($exit)
			{
				$cache->destroy('_stk_prune_attachments');
				if ((sizeof($unsuccess)))
				{
					trigger_error('' . $list . '', E_USER_WARNING);
				}
				else
				{
					trigger_error('' . $list . '');
				}
			}
			else
			{
				meta_refresh(3, append_sid("" . STK_ROOT_PATH . "index." . PHP_EXT . "", 'c=admin&amp;t=prune_attachments&sa=true'));
				trigger_error('' . $user->lang['PRUNE_ATTACHMENTS_PROGRESS'] . '<br />' . $list . '');
			}
		}

		page_header(user_lang('PRUNE_ATTACHMENTS'));

		$template->assign_vars(array(
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, 't=prune_attachments&amp;go=1'),
/*
			'L_PRUNE_ATTACHMENTS'			=> user_lang('PRUNE_ATTACHMENTS'),
			'L_PRUNE_ATTACHMENTS_EXPLAIN'	=> user_lang('PRUNE_ATTACHMENTS_EXPLAIN'),
*/
		));

		$template->set_filenames(array(
			'body' => 'tools/prune_attachments.html',
		));

		page_footer();
	}
}

function scan($path,&$res)
{
	$mass = scandir($path);
	for($i = 0; $i <= count($mass) - 1; $i++)
	{
		if($mass[$i] != '..' && $mass[$i] != '.' && $mass[$i] != 'index.htm' && $mass[$i] != '.htaccess')
		{
			array_push($res, '' . $path . '/' . $mass[$i] . '');
		}
		if(!strstr($mass[$i], '.'))
		{
			if(is_dir($path . '/' . $mass[$i]))
			{
				scan($path . '/' . $mass[$i], $res);
			}
		}
	}
	return $res;
}
