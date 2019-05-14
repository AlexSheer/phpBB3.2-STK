<?php
/**
*
* @package Support Toolkit - Clear Extensions
* @version $Id$
* @copyright (c) 2014 Sheer
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

class clear_extensions
{
	function run_tool(&$error)
	{
		global $cache, $db, $template, $request, $lang, $config;

		$uids = $request->variable('marked_name', array('', ''));

		if (empty($uids))
		{
			$error[] = 'NO_EXT_SELECTED';
			trigger_error($lang['NO_EXT_SELECTED'], E_USER_WARNING);
		}

		if (confirm_box(true) || (@phpversion() >= '7.0.0'))
		{
			$sql = 'SELECT ext_name FROM ' . EXT_TABLE . '
				WHERE ' . $db->sql_in_set('ext_name', $uids, false);
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result))
			{
				$ext_name = explode('/', $row['ext_name']);
				$keyword = '*' . $ext_name[1] . '*';
				$sql = 'DELETE FROM ' . MIGRATIONS_TABLE . '
					WHERE migration_name ' . $db->sql_like_expression(str_replace('*', $db->get_any_char(), $keyword));
				$db->sql_query($sql);
			}
			$db->sql_freeresult($result);

			$sql = 'DELETE FROM ' . EXT_TABLE . '
				WHERE ' . $db->sql_in_set('ext_name', $uids, false);
			$db->sql_query($sql);
			if (empty($error))
			{
				// Purge the cache
				$cache->purge();
				trigger_error($lang['CLEAR_EXT_SUCCESS']);
			}
		}
		else
		{
			$hidden = build_hidden_fields(array('marked_name' => $uids));
			confirm_box(false, $lang['EXT_DELETE_CONFIRM'], $hidden, 'confirm_body.html', STK_DIR_NAME . '/index.' . PHP_EXT . '?c=admin&amp;t=clear_extensions&amp;submit=' . true);
		}
	}

	function display_options()
	{
		global $db, $template, $lang, $cache, $request, $phpbb_extension_manager, $config, $user;
		$this->ext_manager = $phpbb_extension_manager;
 		//print_r($user->lang);
		$user->add_lang('acp/extensions');
		$off = $request->variable('off', false);
		$on = $request->variable('on', false);

		page_header($lang['CLEAR_EXTENSIONS']);
		$no_composer = false;

		if ($off)
		{
			$uids = $request->variable('marked_name', array('', ''));
			if (empty($uids))
			{
				$error[] = 'NO_EXT_SELECTED';
				trigger_error($lang['NO_EXT_SELECTED'], E_USER_WARNING);
			}
			if (confirm_box(true) || (@phpversion() >= '7.0.0'))
			{
				$sql = 'UPDATE ' . EXT_TABLE . '
					SET ext_active = 0
					WHERE ' . $db->sql_in_set('ext_name', $uids, false);
				$db->sql_query($sql);
				$cache->purge(); // Purge the cache
				trigger_error($lang['OFF_EXT_SUCCESS']);
			}
			else
			{
				$hidden = build_hidden_fields(array('marked_name' => $uids));
				confirm_box(false, $lang['EXT_OFF_CONFIRM'], $hidden, 'confirm_body.html', STK_DIR_NAME . '/index.' . PHP_EXT . '?c=admin&amp;t=clear_extensions&amp;off=' . true);
			}
		}

		if ($on)
		{
			$uids = request_var('marked_name', array('', ''));
			if (empty($uids))
			{
				$error[] = 'NO_EXT_SELECTED';
				trigger_error('NO_EXT_SELECTED', E_USER_WARNING);
			}

			$sql = 'UPDATE ' . EXT_TABLE . '
				SET ext_active = 1
				WHERE ' . $db->sql_in_set('ext_name', $uids, false);
			$db->sql_query($sql);
			$cache->purge(); // Purge the cache
			trigger_error($lang['ON_EXT_SUCCESS']);
		}

		$pattern = array('"', ' ');
		$row_set_disabled = $row_set = array();

		$sql = 'SELECT ext_name, ext_active
			FROM ' . EXT_TABLE . '
				WHERE ext_active = 1
				ORDER BY ext_name DESC';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$row_set[] = $row;
		}

		$db->sql_freeresult($result);
		$sql = 'SELECT ext_name, ext_active
			FROM ' . EXT_TABLE . '
				WHERE ext_active = 0
				ORDER BY ext_name DESC';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$row_set_disabled[] = $row;
		}
		$db->sql_freeresult($result);

		$row_set = array_merge($row_set, $row_set_disabled);

		foreach ($row_set as $key => $row)
		{
			$path = explode('/', $row['ext_name']);
			$display_name = $root = $missing_path = '';
			foreach($path as $key => $ext_path)
			{
				if($dir = @opendir('' . PHPBB_ROOT_PATH . 'ext/' . $root . '' . $ext_path . ''))
				{
					$file = readdir($dir);
					$root = '' . $ext_path. '/';
				}
				else
				{
					$missing_path = $ext_path;
					break;
				}
			}

			if (!$missing_path)
			{
				if (file_exists('' . PHPBB_ROOT_PATH . 'ext/' . $row['ext_name'] . '/composer.json'))
				{
					$buffer =  file_get_contents('' . PHPBB_ROOT_PATH . 'ext/' . $row['ext_name'] . '/composer.json');
					if ($buffer)
					{
						$obj = json_decode($buffer);
						$display_name = $obj->{'extra'}->{'display-name'};
						$name = $obj->{'name'};
					}
				}
				else
				{
					$no_composer = true;
				}

				$updates_available = false;
				$md_manager = $this->ext_manager->create_extension_metadata_manager($name);
				$meta = $md_manager->get_metadata('all');
				$version_check_url = false;
				$version_check_fail = false;
				$download = false;
				$current = false;
				$update_info = array();
				if (isset($meta['extra']['version-check']))
				{
					$version_check_url = 'http://' . $meta['extra']['version-check']['host'] . '' . $meta['extra']['version-check']['directory'] . '/' . $meta['extra']['version-check']['filename'] .'';
					try
					{
						$updates_available = $this->ext_manager->version_check($md_manager, false, false, $config['extension_force_unstable'] ? 'unstable' : null);
						if ($updates_available)
						{
							$version_check = $meta['extra']['version-check'];
							$version_helper = new \phpbb\version_helper($cache, $config, new \phpbb\file_downloader());
							$version_helper->set_current_version($meta['version']);
							$version_helper->set_file_location($version_check['host'], $version_check['directory'], $version_check['filename'], isset($version_check['ssl']) ? $version_check['ssl'] : false);
							$versions = $version_helper->get_versions_matching_stability(true, true);
							$current_version = $meta['version'];
							$force_update = $force_cache = false;
							preg_match('/^(\d+\.\d+).*$/', $config['version'], $matches);
							$current_branch = $matches[1];
							// Filter out any versions less than the current version
							$versions = array_filter($versions, function($data) use ($version_helper, $current_version) {
								return $version_helper->compare($data['current'], $current_version, '>=');
							});

							// Filter out any phpbb branches less than the current version
							$branches = array_filter(array_keys($versions), function($branch) use ($version_helper, $current_branch) {
								return $version_helper->compare($branch, $current_branch, '>=');
							});
							if (!empty($branches))
							{
								$versions = array_intersect_key($versions, array_flip($branches));
							}
							else
							{
								// If branches are empty, it means the current phpBB branch is newer than any branch the
								// extension was validated against. Reverse sort the versions array so we get the newest
								// validated release available.
								krsort($versions);
							}
							// Get the first available version from the previous list.
							$update_info = array_reduce($versions, function($value, $data) use ($version_helper, $current_version) {
								if ($value === null && $version_helper->compare($data['current'], $current_version, '>='))
								{
									if (!$data['eol'] && (!$data['security'] || $version_helper->compare($data['security'], $data['current'], '<=')))
									{
										return $version_helper->compare($data['current'], $current_version, '>') ? $data : array();
									}
									else
									{
										return null;
									}
								}

								return $value;
							});
							$download = (isset($update_info['download'])) ? $update_info['download'] : $update_info['announcement'];
							$current = (isset($update_info['current'])) ? $update_info['current'] : '';
						}
					}
					catch (\RuntimeException $e)
					{
						$version_check_fail = true;
					}
				}
			}

			$template->assign_block_vars('row', array(
				'EXT_NAME'				=> $row['ext_name'],
				'VERSION'				=> $meta['version'],
				'VERSION_CHECK_FAIL'	=> $version_check_fail,
				'VERSION_NOT_UP_TO_DATE'=> ($updates_available) ? true : false,
				'VERSION_CHECK'			=> $version_check_url,
				'DOWNLOAD'				=> $download,
				'MISSING_PATH'			=> ($missing_path) ? $missing_path : '',
				'NO_COMPOSER'			=> ($no_composer) ? true : false,
				'DISPLAY_NAME'			=> ($display_name) ? $display_name : sprintf($lang['NO_COMPOSER'], $row['ext_name']),
				'NO_COMPOSER'			=> ($display_name) ? false : true,
				'S_ACTIVE'				=> $row['ext_active'],
				'EXT_MISSING_PATH'		=> ($missing_path) ? sprintf($lang['EXT_MISSING_PATH'], $row['ext_name']) : '',
				'L_NOT_UP_TO_DATE'		=> sprintf($user->lang['NOT_UP_TO_DATE'], $current),
			));
			$version_check_fail = false;
		}

		$template->assign_vars(array(
			'S_ACTION'		=> append_sid("" . STK_ROOT_PATH . "index." . PHP_EXT . "", 'c=admin&amp;t=clear_extensions'),
			'L_UP_TO_DATE'	=> sprintf($user->lang['UP_TO_DATE'], ''),
		));

		$template->set_filenames(array(
			'body' => 'tools/clear_extensions.html',
		));

		page_footer();
	}
}
