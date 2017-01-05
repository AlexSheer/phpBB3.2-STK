<?php
/**
 *
 * @package Support Toolkit - Prune Avatars
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
 * Make sure that all avatar files on the database
 */
class prune_avatars
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

		$submit = $request->variable('sa', false);

		if ($submit)
		{
			$files = $bd_files = $delete_list = $unsuccess = array();

			ignore_user_abort(true);
			set_time_limit(0);

			$dir = '' . PHPBB_ROOT_PATH . '' . $config['avatar_path'] . '/';
			$files = $cache->get('_stk_prune_avatar'); // Try get data from cache
			if(!$files)
			{
				// No data in cache
				$files = array_diff(scandir($dir), array('..', '.', '.htaccess', 'index.htm'));

				$sql = 'SELECT user_id, user_avatar
						FROM ' . USERS_TABLE . '
						WHERE user_avatar_type = \'avatar.driver.upload\'';
				$result = $db->sql_query($sql);

				while($data = $db->sql_fetchrow($result))
				{
					$ext = explode('.', $data['user_avatar']);
					$filename = explode('_', $data['user_avatar']);
					$bd_files[] = '' . $config['avatar_salt'] . '_' . $filename[0] . '.' . $ext[1] . '';
				}
				$db->sql_freeresult($result);
				$files = array_diff($files, $bd_files);
				array_map('trim', array_unique($files));
				sort($files);
				$cache->put('_stk_prune_avatar', $files);
			}

			$count = 0;
			foreach ($files as $del_file)
			{
				if (file_exists($dir.$del_file))
				{
					if (@unlink($dir.$del_file))
					{
						$delete_list[] = $dir.$del_file;
					}
					else
					{
						$unsuccess[] = $dir.$del_file;
					}

					$files = array_diff($files, array($del_file));

					sort($files);
					$count++;
				}
				if($count > ($this->_batch_size - 1))
				{
					$cache->destroy('_stk_prune_avatar');
					$cache->put('_stk_prune_avatar', $files);
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
				$list = (sizeof($unsuccess)) ? '' : user_lang('PRUNE_AVATARS_FINISHED');
				$exit = true;
			}

			if(sizeof($unsuccess))
			{
				$list .= '' . user_lang('PRUNE_AVATARS_FAIL') . '<br />' . implode('<br />', $unsuccess) . '';
			}

			if($exit)
			{
				$cache->destroy('_stk_prune_avatar');
				if ((sizeof($unsuccess)))
				{
					trigger_error('' . $list . '', E_USER_WARNING);
				}
				else
				{
					trigger_error('' .$list . '');
				}
			}
			else
			{
				meta_refresh(3, append_sid("" . STK_ROOT_PATH . "index." . PHP_EXT . "", 'c=admin&amp;t=prune_avatars&sa=true'));
				trigger_error('' . user_lang('PRUNE_AVATARS_PROGRESS') . '<br />' . $list . '');
			}
		}

		page_header(user_lang('PRUNE_AVATARS'));

		$template->assign_vars(array(
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, 't=prune_avatars&amp;go=1'),

/*			'L_PRUNE_AVATARS'			=> user_lang('PRUNE_AVATARS'),
			'L_PRUNE_AVATARS_EXPLAIN'	=> user_lang('PRUNE_AVATARS_EXPLAIN'),
*/
		));

		$template->set_filenames(array(
			'body' => 'tools/prune_avatars.html',
		));

		page_footer();
	}
}
