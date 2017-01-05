<?php
/**
*
* This file is part of the phpBB Forum Software package.
*
* @copyright (c) phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* For full copyright and license information, please see
* the docs/CREDITS.txt file.
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
* - Able to check for new module versions (modes changed/adjusted/added/removed)
* Icons for:
* - module enabled and displayed (common)
* - module enabled and not displayed
* - module deactivated
* - category (enabled)
* - category disabled
*/

class acp_modules
{
	var $module_class = '';
	var $parent_id;
	var $u_action;

	/**
	* Get row for specified module
	*/
	function get_module_row($module_id)
	{
		global $db, $user;

		$sql = 'SELECT *
			FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND module_id = $module_id";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$row)
		{
			trigger_error($user->lang['NO_MODULE'] . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id), E_USER_WARNING);
		}

		return $row;
	}

	/**
	* Get available module information from module files
	*
	* @param string $module
	* @param bool|string $module_class
	* @param bool $use_all_available Use all available instead of just all
	* 						enabled extensions
	* @return array
	*/
	function get_module_infos($module = '', $module_class = false, $use_all_available = false)
	{
		global $phpbb_extension_manager, $phpbb_root_path, $phpEx;

		$module_class = ($module_class === false) ? $this->module_class : $module_class;

		$directory = $phpbb_root_path . 'includes/' . $module_class . '/info/';
		$fileinfo = array();

		$finder = $phpbb_extension_manager->get_finder($use_all_available);

		$modules = $finder
			->extension_suffix('_module')
			->extension_directory("/$module_class")
			->core_path("includes/$module_class/info/")
			->core_prefix($module_class . '_')
			->get_classes(true);

		foreach ($modules as $cur_module)
		{
			// Skip entries we do not need if we know the module we are
			// looking for
			if ($module && strpos(str_replace('\\', '_', $cur_module), $module) === false && $module !== $cur_module)
			{
				continue;
			}

			$info_class = preg_replace('/_module$/', '_info', $cur_module);

			// If the class does not exist it might be following the old
			// format. phpbb_acp_info_acp_foo needs to be turned into
			// acp_foo_info and the respective file has to be included
			// manually because it does not support auto loading
			$old_info_class_file = str_replace("phpbb_{$module_class}_info_", '', $cur_module);
			$old_info_class = $old_info_class_file . '_info';

			if (class_exists($old_info_class))
			{
				$info_class = $old_info_class;
			}
			else if (!class_exists($info_class))
			{
				$info_class = $old_info_class;
				// need to check class exists again because previous checks triggered autoloading
				if (!class_exists($info_class) && file_exists($directory . $old_info_class_file . '.' . $phpEx))
				{
					include($directory . $old_info_class_file . '.' . $phpEx);
				}
			}

			if (class_exists($info_class))
			{
				$info = new $info_class();
				$module_info = $info->module();

				$main_class = (isset($module_info['filename'])) ? $module_info['filename'] : $cur_module;

				$fileinfo[$main_class] = $module_info;
			}
		}

		ksort($fileinfo);

		return $fileinfo;
	}

	/**
	* Simple version of jumpbox, just lists modules
	*/
	function make_module_select($select_id = false, $ignore_id = false, $ignore_acl = false, $ignore_nonpost = false, $ignore_emptycat = true, $ignore_noncat = false)
	{
		global $db, $user, $auth, $config;

		$sql = 'SELECT module_id, module_enabled, module_basename, parent_id, module_langname, left_id, right_id, module_auth
			FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
			ORDER BY left_id ASC";
		$result = $db->sql_query($sql);

		$right = $iteration = 0;
		$padding_store = array('0' => '');
		$module_list = $padding = '';

		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['left_id'] < $right)
			{
				$padding .= '&nbsp; &nbsp;';
				$padding_store[$row['parent_id']] = $padding;
			}
			else if ($row['left_id'] > $right + 1)
			{
				$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : '';
			}

			$right = $row['right_id'];

			if (!$ignore_acl && $row['module_auth'])
			{
				// We use zero as the forum id to check - global setting.
				if (!p_master::module_auth($row['module_auth'], 0))
				{
					continue;
				}
			}

			// ignore this module?
			if ((is_array($ignore_id) && in_array($row['module_id'], $ignore_id)) || $row['module_id'] == $ignore_id)
			{
				continue;
			}

			// empty category
			if (!$row['module_basename'] && ($row['left_id'] + 1 == $row['right_id']) && $ignore_emptycat)
			{
				continue;
			}

			// ignore non-category?
			if ($row['module_basename'] && $ignore_noncat)
			{
				continue;
			}

			$selected = (is_array($select_id)) ? ((in_array($row['module_id'], $select_id)) ? ' selected="selected"' : '') : (($row['module_id'] == $select_id) ? ' selected="selected"' : '');

			$langname = $this->lang_name($row['module_langname']);
			$module_list .= '<option value="' . $row['module_id'] . '"' . $selected . ((!$row['module_enabled']) ? ' class="disabled"' : '') . '>' . $padding . $langname . '</option>';

			$iteration++;
		}
		$db->sql_freeresult($result);

		unset($padding_store);

		return $module_list;
	}

	/**
	* Get module branch
	*/
	function get_module_branch($module_id, $type = 'all', $order = 'descending', $include_module = true)
	{
		global $db;

		switch ($type)
		{
			case 'parents':
				$condition = 'm1.left_id BETWEEN m2.left_id AND m2.right_id';
			break;

			case 'children':
				$condition = 'm2.left_id BETWEEN m1.left_id AND m1.right_id';
			break;

			default:
				$condition = 'm2.left_id BETWEEN m1.left_id AND m1.right_id OR m1.left_id BETWEEN m2.left_id AND m2.right_id';
			break;
		}

		$rows = array();

		$sql = 'SELECT m2.*
			FROM ' . MODULES_TABLE . ' m1
			LEFT JOIN ' . MODULES_TABLE . " m2 ON ($condition)
			WHERE m1.module_class = '" . $db->sql_escape($this->module_class) . "'
				AND m2.module_class = '" . $db->sql_escape($this->module_class) . "'
				AND m1.module_id = $module_id
			ORDER BY m2.left_id " . (($order == 'descending') ? 'ASC' : 'DESC');
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			if (!$include_module && $row['module_id'] == $module_id)
			{
				continue;
			}

			$rows[] = $row;
		}
		$db->sql_freeresult($result);

		return $rows;
	}

	/**
	* Remove modules cache file
	*/
	function remove_cache_file()
	{
		global $phpbb_container;

		// Sanitise for future path use, it's escaped as appropriate for queries
		$p_class = str_replace(array('.', '/', '\\'), '', basename($this->module_class));

		$phpbb_container->get('cache.driver')->destroy('_modules_' . $p_class);

		// Additionally remove sql cache
		$phpbb_container->get('cache.driver')->destroy('sql', MODULES_TABLE);
	}

	/**
	* Return correct language name
	*/
	function lang_name($module_langname)
	{
		global $user;

		return (!empty($user->lang[$module_langname])) ? $user->lang[$module_langname] : $module_langname;
	}

	/**
	* Update/Add module
	*
	* @param array	&$module_data	The module data
	* @param bool	$run_inline 	if set to true errors will be returned and no logs being written
	*/
	function update_module_data(&$module_data, $run_inline = false)
	{
		global $db, $user;

		if (!isset($module_data['module_id']))
		{
			// no module_id means we're creating a new category/module
			if ($module_data['parent_id'])
			{
				$sql = 'SELECT left_id, right_id
					FROM ' . MODULES_TABLE . "
					WHERE module_class = '" . $db->sql_escape($module_data['module_class']) . "'
						AND module_id = " . (int) $module_data['parent_id'];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					if ($run_inline)
					{
						return 'PARENT_NO_EXIST';
					}

					trigger_error($user->lang['PARENT_NO_EXIST'] . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id), E_USER_WARNING);
				}

				// Workaround
				$row['left_id'] = (int) $row['left_id'];
				$row['right_id'] = (int) $row['right_id'];

				$sql = 'UPDATE ' . MODULES_TABLE . "
					SET left_id = left_id + 2, right_id = right_id + 2
					WHERE module_class = '" . $db->sql_escape($module_data['module_class']) . "'
						AND left_id > {$row['right_id']}";
				$db->sql_query($sql);

				$sql = 'UPDATE ' . MODULES_TABLE . "
					SET right_id = right_id + 2
					WHERE module_class = '" . $db->sql_escape($module_data['module_class']) . "'
						AND {$row['left_id']} BETWEEN left_id AND right_id";
				$db->sql_query($sql);

				$module_data['left_id'] = (int) $row['right_id'];
				$module_data['right_id'] = (int) $row['right_id'] + 1;
			}
			else
			{
				$sql = 'SELECT MAX(right_id) AS right_id
					FROM ' . MODULES_TABLE . "
					WHERE module_class = '" . $db->sql_escape($module_data['module_class']) . "'";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$module_data['left_id'] = (int) $row['right_id'] + 1;
				$module_data['right_id'] = (int) $row['right_id'] + 2;
			}

			$sql = 'INSERT INTO ' . MODULES_TABLE . ' ' . $db->sql_build_array('INSERT', $module_data);
			$db->sql_query($sql);

			$module_data['module_id'] = $db->sql_nextid();

			if (!$run_inline)
			{
				add_log('admin', 'LOG_MODULE_ADD', $this->lang_name($module_data['module_langname']));
			}
		}
		else
		{
			$row = $this->get_module_row($module_data['module_id']);

			if ($module_data['module_basename'] && !$row['module_basename'])
			{
				// we're turning a category into a module
				$branch = $this->get_module_branch($module_data['module_id'], 'children', 'descending', false);

				if (sizeof($branch))
				{
					return array($user->lang['NO_CATEGORY_TO_MODULE']);
				}
			}

			if ($row['parent_id'] != $module_data['parent_id'])
			{
				$this->move_module($module_data['module_id'], $module_data['parent_id']);
			}

			$update_ary = $module_data;
			unset($update_ary['module_id']);

			$sql = 'UPDATE ' . MODULES_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $update_ary) . "
				WHERE module_class = '" . $db->sql_escape($module_data['module_class']) . "'
					AND module_id = " . (int) $module_data['module_id'];
			$db->sql_query($sql);

			if (!$run_inline)
			{
				add_log('admin', 'LOG_MODULE_EDIT', $this->lang_name($module_data['module_langname']));
			}
		}

		return array();
	}

	/**
	* Move module around the tree
	*/
	function move_module($from_module_id, $to_parent_id)
	{
		global $db;

		$moved_modules = $this->get_module_branch($from_module_id, 'children', 'descending');
		$from_data = $moved_modules[0];
		$diff = sizeof($moved_modules) * 2;

		$moved_ids = array();
		for ($i = 0, $size = sizeof($moved_modules); $i < $size; ++$i)
		{
			$moved_ids[] = $moved_modules[$i]['module_id'];
		}

		// Resync parents
		$sql = 'UPDATE ' . MODULES_TABLE . "
			SET right_id = right_id - $diff
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND left_id < " . (int) $from_data['right_id'] . '
				AND right_id > ' . (int) $from_data['right_id'];
		$db->sql_query($sql);

		// Resync righthand side of tree
		$sql = 'UPDATE ' . MODULES_TABLE . "
			SET left_id = left_id - $diff, right_id = right_id - $diff
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND left_id > " . (int) $from_data['right_id'];
		$db->sql_query($sql);

		if ($to_parent_id > 0)
		{
			$to_data = $this->get_module_row($to_parent_id);

			// Resync new parents
			$sql = 'UPDATE ' . MODULES_TABLE . "
				SET right_id = right_id + $diff
				WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
					AND " . (int) $to_data['right_id'] . ' BETWEEN left_id AND right_id
					AND ' . $db->sql_in_set('module_id', $moved_ids, true);
			$db->sql_query($sql);

			// Resync the righthand side of the tree
			$sql = 'UPDATE ' . MODULES_TABLE . "
				SET left_id = left_id + $diff, right_id = right_id + $diff
				WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
					AND left_id > " . (int) $to_data['right_id'] . '
					AND ' . $db->sql_in_set('module_id', $moved_ids, true);
			$db->sql_query($sql);

			// Resync moved branch
			$to_data['right_id'] += $diff;
			if ($to_data['right_id'] > $from_data['right_id'])
			{
				$diff = '+ ' . ($to_data['right_id'] - $from_data['right_id'] - 1);
			}
			else
			{
				$diff = '- ' . abs($to_data['right_id'] - $from_data['right_id'] - 1);
			}
		}
		else
		{
			$sql = 'SELECT MAX(right_id) AS right_id
				FROM ' . MODULES_TABLE . "
				WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
					AND " . $db->sql_in_set('module_id', $moved_ids, true);
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$diff = '+ ' . (int) ($row['right_id'] - $from_data['left_id'] + 1);
		}

		$sql = 'UPDATE ' . MODULES_TABLE . "
			SET left_id = left_id $diff, right_id = right_id $diff
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND " . $db->sql_in_set('module_id', $moved_ids);
		$db->sql_query($sql);
	}

	/**
	* Remove module from tree
	*/
	function delete_module($module_id)
	{
		global $db, $user;

		$row = $this->get_module_row($module_id);

		$branch = $this->get_module_branch($module_id, 'children', 'descending', false);

		if (sizeof($branch))
		{
			return array($user->lang['CANNOT_REMOVE_MODULE']);
		}

		// If not move
		$diff = 2;
		$sql = 'DELETE FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND module_id = $module_id";
		$db->sql_query($sql);

		$row['right_id'] = (int) $row['right_id'];
		$row['left_id'] = (int) $row['left_id'];

		// Resync tree
		$sql = 'UPDATE ' . MODULES_TABLE . "
			SET right_id = right_id - $diff
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND left_id < {$row['right_id']} AND right_id > {$row['right_id']}";
		$db->sql_query($sql);

		$sql = 'UPDATE ' . MODULES_TABLE . "
			SET left_id = left_id - $diff, right_id = right_id - $diff
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND left_id > {$row['right_id']}";
		$db->sql_query($sql);

		add_log('admin', 'LOG_MODULE_REMOVED', $this->lang_name($row['module_langname']));

		return array();

	}

	/**
	* Move module position by $steps up/down
	*/
	function move_module_by($module_row, $action = 'move_up', $steps = 1)
	{
		global $db;

		/**
		* Fetch all the siblings between the module's current spot
		* and where we want to move it to. If there are less than $steps
		* siblings between the current spot and the target then the
		* module will move as far as possible
		*/
		$sql = 'SELECT module_id, left_id, right_id, module_langname
			FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND parent_id = " . (int) $module_row['parent_id'] . '
				AND ' . (($action == 'move_up') ? 'right_id < ' . (int) $module_row['right_id'] . ' ORDER BY right_id DESC' : 'left_id > ' . (int) $module_row['left_id'] . ' ORDER BY left_id ASC');
		$result = $db->sql_query_limit($sql, $steps);

		$target = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$target = $row;
		}
		$db->sql_freeresult($result);

		if (!sizeof($target))
		{
			// The module is already on top or bottom
			return false;
		}

		/**
		* $left_id and $right_id define the scope of the nodes that are affected by the move.
		* $diff_up and $diff_down are the values to substract or add to each node's left_id
		* and right_id in order to move them up or down.
		* $move_up_left and $move_up_right define the scope of the nodes that are moving
		* up. Other nodes in the scope of ($left_id, $right_id) are considered to move down.
		*/
		if ($action == 'move_up')
		{
			$left_id = (int) $target['left_id'];
			$right_id = (int) $module_row['right_id'];

			$diff_up = (int) ($module_row['left_id'] - $target['left_id']);
			$diff_down = (int) ($module_row['right_id'] + 1 - $module_row['left_id']);

			$move_up_left = (int) $module_row['left_id'];
			$move_up_right = (int) $module_row['right_id'];
		}
		else
		{
			$left_id = (int) $module_row['left_id'];
			$right_id = (int) $target['right_id'];

			$diff_up = (int) ($module_row['right_id'] + 1 - $module_row['left_id']);
			$diff_down = (int) ($target['right_id'] - $module_row['right_id']);

			$move_up_left = (int) ($module_row['right_id'] + 1);
			$move_up_right = (int) $target['right_id'];
		}

		// Now do the dirty job
		$sql = 'UPDATE ' . MODULES_TABLE . "
			SET left_id = left_id + CASE
				WHEN left_id BETWEEN {$move_up_left} AND {$move_up_right} THEN -{$diff_up}
				ELSE {$diff_down}
			END,
			right_id = right_id + CASE
				WHEN right_id BETWEEN {$move_up_left} AND {$move_up_right} THEN -{$diff_up}
				ELSE {$diff_down}
			END
			WHERE module_class = '" . $db->sql_escape($this->module_class) . "'
				AND left_id BETWEEN {$left_id} AND {$right_id}
				AND right_id BETWEEN {$left_id} AND {$right_id}";
		$db->sql_query($sql);

		$this->remove_cache_file();

		return $this->lang_name($target['module_langname']);
	}
}
