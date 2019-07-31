<?php
/**
*
* @package Support Toolkit - Database Cleaner
* @version $Id$
* @copyright (c) 2009 phpBB Group
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
* Class that displays all overview pages
*/
class database_cleaner_views
{
	/**
	* @var Array This step needs a confirmbox, this array contains all the data
	*
	* $_confirm_box = array(
	*	'title'		=> 'The title',
	*	'message	=> 'The message',
	* );
	*/
	var $_confirm_box = array();

	/**
	* @var Array Array that is used to build lists of found changes
	*/
	var $_section_data = array();

	/**
	* @var database_cleaner_data The database cleaner data object
	*/
	var $db_cleaner = array();

	/**
	* @var String Some steps have a specific notice when not ran
	*/
	var $not_run_message = '';

	/**
	* @var String The message that is displayed once a step is done successfully
	*/
	var $success_message = '';

	/**
	* @var Boolean Has changes.
	*/
	var $_has_changes = false;

	/**
	* Constructor
	* @param database_cleaner $db_cleaner Object of the current database cleaner class
	*/
	function database_cleaner_views($db_cleaner)
	{
		$this->db_cleaner = $db_cleaner;
	}

	/**
	* Output the page
	*/
	function display()
	{
		global $error, $template, $request, $config, $lang;

		$did_run = $request->variable('did_run', false);

		// Error?
		if (!empty($error))
		{
			$error_msg = '';
			foreach ($error as $e)
			{
				$error_msg .= user_lang($e) . '<br />';
			}
			$template->assign_var('ERROR_MESSAGE', $error_msg);
		}

		// This page has a "confirm box"
		if (!empty($this->_confirm_box))
		{
			$template->assign_vars(array(
				'L_CONFIRM_TITLE'	=> user_lang($this->_confirm_box['title']),
				'L_CONFIRM_EXPLAIN'	=> user_lang($this->_confirm_box['message']),
				'S_CONFIRM_BOX'		=> true,
			));
		}
		// This step found some changes
		elseif (!empty($this->_section_data))
		{
			// Output the sections
			foreach($this->_section_data as $section)
			{
				// Its possible the section exist but there aren't any items
				if (empty($section['ITEMS']))
				{
					continue;
				}

				// Create the section
				$template->assign_block_vars('section', array(
					'NAME'	=> user_lang($section['NAME']),
					'TITLE'	=> user_lang($section['TITLE']),
				));

				// Output the items
				foreach($section['ITEMS'] as $item)
				{
					$template->assign_block_vars('section.items', array(
						'NAME'			=> user_lang($item['NAME']),
						'FIELD_NAME'	=> user_lang($item['FIELD_NAME']),
						'MISSING'		=> $item['MISSING'],
						'FIND'			=> (isset($item['FIND'])) ? $item['FIND'] : '',
					));
				}
			}
		}

		// Assign no changes text
		if (empty($this->_section_data) && isset($lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]]))
		{
			$template->assign_vars(array(
				'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
				'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			));
		}

		// Determine the link for the next step
		if (!isset($this->_u_next_step))
		{
			if ($this->db_cleaner->step == 1)
			{
				$config->set('board_disable', 1);
				$config->set('board_disable_msg', user_lang('BOARD_DISABLE_REASON'));
			}
			if ($this->_has_changes || !empty($this->_confirm_box))
			{
				$_u_next_step = append_sid(STK_INDEX, array('c' => 'support', 't' => 'database_cleaner', 'step' => $this->db_cleaner->step, 'submit' => true));
			}
			else
			{
				$_u_next_step = append_sid(STK_INDEX, array('c' => 'support', 't' => 'database_cleaner', 'step' => ($this->db_cleaner->step + 1)));
			}
		}
		else
		{
			$_u_next_step = $this->_u_next_step;
		}

		$msg = $this->success_message;
		if (!$did_run && $this->db_cleaner->step > 0)
		{
			$msg = (!empty($this->not_run_message)) ? $this->not_run_message : ((isset($lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step - 1]])) ? $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step - 1]] : $this->success_message);
		}

		$s_options = '';
		$actions =array(
			'introduction'			=> $lang['INTRODUCTION'],
			'tables'				=> $lang['DATABASE_TABLES'],
			'indexes'				=> $lang['INDEXES'],
			'columns'				=> $lang['COLUMNS'],
			'config'				=> $lang['CONFIG_SETTINGS'],
			'extension_groups'		=> $lang['ACP_EXTENSION_GROUPS'],
			'extensions'			=> $lang['EXTENSION_FILE_GROUPS'],
			'permissions'			=> $lang['PERMISSION_SETTINGS'],
			'groups'				=> $lang['SYSTEM_GROUPS'],
			'roles'					=> $lang['ROLE_SETTINGS'],
			'role_data'				=> $lang['RESET_ROLE_DATA'],
			'acp_modules'			=> $lang['ACP_MODULES_SETTINGS'],
			'modules'				=> $lang['RESET_MODULES'],
			'bots'					=> $lang['RESET_BOTS'],
			'report_reasons'		=> $lang['RESET_REPORT_REASONS'],
			'final_step'			=> $lang['SECTION_NOT_CHANGED_TITLE']['final_step']
		);
		foreach ($this->db_cleaner->step_to_action as $step => $action)
		{
			$s_selected = ($step == $this->db_cleaner->step + 1) ? ' selected="selected"' : '';
			$s_options .= '<option value="' . $step . '" ' . $s_selected . '>' . $actions[$action] . '</option>';
		}

		// Output some stuff we need always
		$template->assign_vars(array(
			'S_HIDDEN_FIELDS'	=> (isset($this->_hidden_fields)) ? build_hidden_fields($this->_hidden_fields) : '',
			'LAST_STEP'			=> sizeof($this->db_cleaner->step_to_action),
			'STEP'				=> $this->db_cleaner->step,
			'SUCCESS_MESSAGE'	=> user_lang($msg),

			// Create submit link, always set "submit" so we'll continue in the run_tool method
			'U_NEXT_STEP'	=> $_u_next_step,

			// Skip next step & go to spcified step
			'U_SKIP_STEP'	=> append_sid(STK_INDEX, 'c=support&t=database_cleaner'),
 			'S_SKIP'		=> ($this->db_cleaner->step > 0 && $this->db_cleaner->step_to_action[$this->db_cleaner->step] != 'final_step') ? true : false,
 			'S_SELECT'		=> $s_options,
		));

		// Do tha page
		page_header(user_lang('DATABASE_CLEANER'), false);

		$template->set_filenames(array(
			'body' => 'tools/database_cleaner.html',
		));

		page_footer();
	}

	/**
	* Reset bots?
	*/
	function bots()
	{
		$this->_confirm_box = array(
			'title'		=> 'RESET_BOTS',
			'message'	=> 'RESET_BOTS_EXPLAIN',
		);

		// Only success message when the modules have been reset
		$this->success_message	= 'RESET_MODULE_SUCCESS';
		$this->not_run_message	= 'RESET_MODULES_SKIP';
	}

	/**
	* Validate all columns in the database
	*/
	function columns()
	{
		global $umil;
		// Time to start going through the database and listing any extra/missing fields
		$last_output_table = '';
		foreach ($this->db_cleaner->data->tables as $table_name => $data)
		{
			// We shouldn't mess with profile fields here.  Users probably will not know what this table does or what would happen if they remove fields added to it.
			if ($table_name == PROFILE_FIELDS_DATA_TABLE)
			{
				continue;
			}

			if ($umil->table_exists($table_name) === false)
			{
				continue;
			}
			$existing_columns = get_columns($table_name);

			if ($existing_columns === false)
			{
				// Table doesn't exist, don't handle here.
				continue;
			}

			$columns = array_unique(array_merge(array_keys($data['COLUMNS']), $existing_columns));
			sort($columns);

			foreach ($columns as $column)
			{
				if ((!isset($data['COLUMNS'][$column]) && in_array($column, $existing_columns)) || (isset($data['COLUMNS'][$column]) && !in_array($column, $existing_columns)))
				{
					// Output the table block if it's not been done yet
					if ($last_output_table != $table_name)
					{
						$last_output_table = $table_name;

						$this->_section_data[$table_name] = array(
							'NAME'	=> $table_name,
							'TITLE'	=> 'COLUMNS',
						);
					}

					// Add the data
					$this->_section_data[$table_name]['ITEMS'][] = array(
						'NAME'			=> $column,
						'FIELD_NAME'	=> $table_name . '_' . $column,
						'MISSING'		=> (!in_array($column, $existing_columns)) ? true : false,
						'FIND'			=> append_sid("" . STK_ROOT_PATH . "finder." . PHP_EXT . "", 'col=' . $column . ''),
					);

					if ($this->_has_changes === false)
					{
						$this->_has_changes = true;
					}
				}
			}
		}

		$this->success_message = 'DATABASE_TABLES_SUCCESS';
	}

	/**
	* Validate all entries in the config table
	*/
	function config()
	{
		global $db, $lang, $template;

		// display extra config variables and let them check/uncheck the ones they want to add/remove
		$this->_section_data['config'] = array(
			'NAME'		=> 'CONFIG_SETTINGS',
			'TITLE'		=> 'ROWS',
		);

		$removed_config = ($db->get_sql_layer() == 'mysql4' || $db->get_sql_layer() == 'mysqli') ? array('auth_oauth_bitly_key', 'auth_oauth_bitly_secret', 'auth_oauth_facebook_key', 'auth_oauth_facebook_secret', 'auth_oauth_google_key', 'auth_oauth_google_secret', 'fulltext_sphinx_id') : array();
		$ignored_congig = array(
			'reparse_lock', 'text_reparser.pm_text_cron_interval', 'text_reparser.pm_text_last_cron', 'text_reparser.poll_option_cron_interval',
			'text_reparser.poll_option_last_cron', 'text_reparser.poll_title_cron_interval', 'text_reparser.poll_title_last_cron', 'auth_oauth_twitter_key', 'auth_oauth_twitter_secret',
			'text_reparser.post_text_cron_interval', 'text_reparser.post_text_last_cron', 'text_reparser.user_signature_cron_interval',
			'text_reparser.user_signature_last_cron', 'cookie_notice', 'load_font_awesome_url', 'smtp_allow_self_signed', 'smtp_verify_peer',
			'smtp_verify_peer_name', 'update_hashes_lock', 'update_hashes_last_cron', 'jab_allow_self_signed', 'jab_verify_peer', 'jab_verify_peer_name', 'enable_update_hashes',
			'auth_oauth_bitly_key', 'auth_oauth_bitly_secret', 'auth_oauth_facebook_key', 'auth_oauth_facebook_secret', 'auth_oauth_google_key', 'auth_oauth_google_secret', 'fulltext_sphinx_id'
		);

		$config_rows = $existing_config = array();
		get_config_rows($this->db_cleaner->data->config, $config_rows, $existing_config);
		foreach ($config_rows as $name)
		{
			// Skip ones that are in the default install and are in the existing config, or if it was removed by a later update
			if ((isset($this->db_cleaner->data->config[$name]) && in_array($name, $existing_config)) || in_array($name, $this->db_cleaner->data->removed_config) || in_array($name, $ignored_congig))
			{
				continue;
			}

			$this->_section_data['config']['ITEMS'][] = array(
				'NAME'			=> $name,
				'FIELD_NAME'	=> $name,
				'MISSING'		=> (!in_array($name, $existing_config)) ? true : false,
				'FIND'		=> append_sid("" . STK_ROOT_PATH . "finder." . PHP_EXT . "", 'c=' . $name . ''),
			);

			if ($this->_has_changes === false)
			{
				$this->_has_changes = true;
			}
		}

		$template->assign_vars(array(
			'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
		));

		$this->success_message = 'DATABASE_COLUMNS_SUCCESS';
	}

	/**
	* Validate the extension groups
	*/
	function extension_groups()
	{
		global $template, $lang;

		// display extra config variables and let them check/uncheck the ones they want to add/remove
		$this->_section_data['extension_groups'] = array(
			'NAME'		=> 'EXTENSION_GROUPS_SETTINGS',
			'TITLE'		=> 'ROWS',
		);

		$extension_groups_rows = $existing_extension_groups = array();
		get_extension_groups_rows($this->db_cleaner->data->extension_groups, $extension_groups_rows, $existing_extension_groups);
		foreach ($extension_groups_rows as $name)
		{
			// Skip ones that are in the default install and are in the existing config
			if (isset($this->db_cleaner->data->extension_groups[$name]) && in_array($name, $existing_extension_groups))
			{
				continue;
			}

			$this->_section_data['extension_groups']['ITEMS'][] = array(
				'NAME'			=> $name,
				'FIELD_NAME'	=> $name,
				'MISSING'		=> (!in_array($name, $existing_extension_groups)) ? true : false,
			);

			if ($this->_has_changes === false)
			{
				$this->_has_changes = true;
			}
		}

		$template->assign_vars(array(
			'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
		));

		$this->success_message = 'CONFIG_UPDATE_SUCCESS';
	}

	/**
	* Validate the extensions
	*/
	function extensions()
	{
		// Build the output
		$last_extension_group = '';
		foreach ($this->db_cleaner->data->extensions as $group => $data)
		{
			$group_ids = array();
			$existing_extensions = get_extensions($group, $group_ids);
			$extensions = array_unique(array_merge($data, $existing_extensions));
			sort($extensions);

			foreach ($extensions as $extension)
			{
				if ((!in_array($extension, $data) && in_array($extension, $existing_extensions)) || (in_array($extension, $data) && !in_array($extension, $existing_extensions)))
				{
					// Output the table block if it's not been done yet
					if ($last_extension_group != $group)
					{
						$last_extension_group = $group;

						$this->_section_data[$group] = array(
							'NAME'	=> user_lang($group),
							'TITLE'	=> 'EXTENSION_FILE_GROUPS',
						);
					}

					// Add the data
					$this->_section_data[$group]['ITEMS'][] = array(
						'NAME'			=> $extension,
						'FIELD_NAME'	=> $group . '_' . $extension,
						'MISSING'		=> (!in_array($extension, $existing_extensions)) ? true : false,
					);

					if ($this->_has_changes === false)
					{
						$this->_has_changes = true;
					}
				}
			}
		}

		$this->success_message = 'EXTENSION_GROUPS_SUCCESS';
	}

	/**
	* Display the last step
	*/
	function final_step()
	{
		global $template;

		// Only success message when the bots have been reset
		$this->success_message	= 'RESET_REPORT_REASONS_SUCCESS';
		$this->not_run_message	= 'RESET_REPORT_REASONS_SKIP';

		$this->_has_changes = true;
	}

	/**
	* Validate all system groups
	*/
	function groups()
	{
		global $template, $lang, $language;
		$language->add_lang(array('acp/common'));

		// Display the system groups that are missing or aren't from a vanilla installation
		$this->_section_data['groups'] = array(
			'NAME'		=> $language->lang('ACP_GROUPS_MANAGEMENT'),
			'TITLE'		=> 'ROWS',
		);

		$group_rows = $existing_groups = array();
		get_group_rows($this->db_cleaner->data->groups, $group_rows, $existing_groups);
		foreach ($group_rows as $name)
		{
			// Skip ones that are in the default install and are in the existing permissions
			if (isset($this->db_cleaner->data->groups[$name]) && in_array($name, $existing_groups))
			{
				continue;
			}

			$this->_section_data['groups']['ITEMS'][] = array(
				'NAME'			=> $lang['G_' . $name],
				'FIELD_NAME'	=> $name,
				'MISSING'		=> (!in_array($name, $existing_groups)) ? true : false,
			);

			if ($this->_has_changes === false)
			{
				$this->_has_changes = true;
			}
		}

		$template->assign_vars(array(
			'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
		));

		$this->success_message = 'PERMISSION_UPDATE_SUCCESS';
	}

	/**
	* Display a quick intro here and make sure they know what they are doing...
	*/
	function introduction()
	{
		global $template;

		$template->assign_vars(array(
			'SUCCESS_TITLE'		=> user_lang('DATABASE_CLEANER'),
			'ERROR_TITLE'		=> ' ',
			'ERROR_MESSAGE'		=> user_lang('DATABASE_CLEANER_WARNING'),
		));

		$this->success_message = 'DATABASE_CLEANER_WELCOME';
	}

	/**
	* Reset modules?
	*/
	function modules()
	{
		$this->_confirm_box = array(
			'title'		=> 'RESET_MODULES',
			'message'	=> 'RESET_MODULES_EXPLAIN',
		);

		$this->success_message = 'DATABASE_ROLE_DATA_SUCCESS';
	}

	/**
	* Validate all permissions
	*/
	function permissions()
	{
		global $template, $lang;

		$this->_section_data['permissions'] = array(
			'NAME'		=> 'PERMISSION_SETTINGS',
			'TITLE'		=> 'ROWS',
		);

		$permission_rows = $existing_permissions = array();
		get_permission_rows($this->db_cleaner->data->acl_options, $permission_rows, $existing_permissions);
		foreach ($permission_rows as $name)
		{
			// Skip ones that are in the default install and are in the existing permissions
			if (isset($this->db_cleaner->data->acl_options[$name]) && in_array($name, $existing_permissions))
			{
				continue;
			}

			$this->_section_data['permissions']['ITEMS'][] = array(
				'NAME'			=> $name,
				'FIELD_NAME'	=> $name,
				'MISSING'		=> (!in_array($name, $existing_permissions)) ? true : false,
				'FIND'			=> append_sid("" . STK_ROOT_PATH . "finder." . PHP_EXT . "", 'p=' . $name . ''),
			);

			if ($this->_has_changes === false)
			{
				$this->_has_changes = true;
			}
		}

		$template->assign_vars(array(
			'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
		));

		$this->success_message = 'EXTENSIONS_SUCCESS';
	}

	/**
	* Reset report reasons?
	*/
	function report_reasons()
	{
		$this->_confirm_box = array(
			'title'		=> 'RESET_REPORT_REASONS',
			'message'	=> 'RESET_REPORT_REASONS_EXPLAIN',
		);

		// Only success message when the bots have been reset
		$this->success_message	= 'RESET_BOT_SUCCESS';
		$this->not_run_message	= 'RESET_BOTS_SKIP';
	}

	/**
	* Reset system roles?
	*/
	function role_data()
	{
		$this->_confirm_box = array(
			'title'		=> 'RESET_ROLE_DATA',
			'message'	=> 'RESET_ROLE_DATA_EXPLAIN',
		);

		$this->success_message = 'DATABASE_ROLES_SUCCESS';
	}

	/**
	* Validate the `acl_roles` table
	*/
	function roles()
	{
		global $template, $lang;

		// display extra config variables and let them check/uncheck the ones they want to add/remove
		$this->_section_data['roles'] = array(
			'NAME'		=> 'ROLE_SETTINGS',
			'TITLE'		=> 'ROWS',
		);

		$role_rows = $existing_roles = array();
		get_role_rows($this->db_cleaner->data->acl_roles, $role_rows, $existing_roles);
		foreach ($role_rows as $name)
		{
			// Skip ones that are in the default install and are in the existing config
			if (isset($this->db_cleaner->data->acl_roles[$name]) && in_array($name, $existing_roles))
			{
				continue;
			}

			$this->_section_data['roles']['ITEMS'][] = array(
				'NAME'			=> $name,
				'FIELD_NAME'	=> $name,
				'MISSING'		=> (!in_array($name, $existing_roles)) ? true : false,
			);

			if ($this->_has_changes === false)
			{
				$this->_has_changes = true;
			}
		}

		$template->assign_vars(array(
			'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
		));

		$this->success_message = 'SYSTEM_GROUP_UPDATE_SUCCESS';
	}

	/**
	* Validate all tables in the database
	*/
	function tables()
	{
		global $table_prefix, $template, $lang, $request;

		$tables_confirm = $request->variable('tables_confirm', false);
		if (!$tables_confirm)
		{
			$found_tables	= get_phpbb_tables();
			$req_tables		= $this->db_cleaner->data->tables;
			$tables			= array_unique(array_merge(array_keys($req_tables), $found_tables));
			sort($tables);

			$this->_section_data['tables'] = array(
				'NAME'		=> 'DATABASE_TABLES',
				'TITLE'		=> 'DATABASE_TABLES',
			);

			foreach ($tables as $table)
			{
				// Table was added or removed
				if (!isset($req_tables[$table]) && in_array($table, $found_tables) || isset($req_tables[$table]) && !in_array($table, $found_tables))
				{
					$this->_section_data['tables']['ITEMS'][] = array(
						'NAME'			=> $table,
						'FIELD_NAME'	=> $table,
						'MISSING'		=> isset($req_tables[$table]) ? true : false,
						'FIND'		=> append_sid("" . STK_ROOT_PATH . "finder." . PHP_EXT . "", 't=' . $table . ''),
					);

					if ($this->_has_changes === false)
					{
						$this->_has_changes = true;
					}
				}
			}

			$template->assign_vars(array(
				'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
				'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			));

			// A bit nasty but the only real work around at this moment
			if (empty($table_prefix) && $this->_has_changes)
			{
				$this->_u_next_step = append_sid(STK_INDEX, array('c' => 'support', 't' => 'database_cleaner', 'step' => $this->db_cleaner->step, 'submit' => false, 'tables_confirm' => true));
			}

			$this->success_message = 'BOARD_DISABLE_SUCCESS';
		}
		else
		{
			// I'n not sure why request_var doesn't work here so we'll do it a bit different
			$tables = array();
			$tems = $request->variable('items', array(''));
			foreach ($tems as $table => $value)
			{
				set_var($table, $table, 'string', true);
				set_var($value, $value, 'string', true);
				$tables["items[{$table}]"] = $value;
			}

			$this->_hidden_fields = $tables;

			$this->_confirm_box = array(
				'title'		=> 'EMPTY_PREFIX',
				'message'	=> 'EMPTY_PREFIX_CONFIRM',
			);
		}
	}

	/**
	* Validate all modules in the database
	*/
	function acp_modules()
	{
		global $db, $lang, $template, $phpEx, $phpbb_root_path, $user, $language;
		$language->add_lang(array('ucp', 'mcp', 'acp/common'));

		$this->_section_data['acp_modules'] = array(
			'NAME'		=> 'ACP_MODULES_SETTINGS',
			'TITLE'		=> 'ROWS',
		);

		$modules = $existing_modules = array();
		get_acp_modules($this->db_cleaner->data->acp_modules, $modules);

		// Find extra modules
		$sql = 'SELECT *
			FROM ' . MODULES_TABLE;
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$existing_modules[] = $row['module_langname'];
			if(in_array($row['module_langname'], $modules))
			{
				continue;
			}

			$module = $row['module_langname'];
			$module_id = $row['module_id'];

			$sql = 'SELECT *
				FROM ' . MODULES_TABLE . '
				WHERE module_id = ' . $row['parent_id'];
			$res = $db->sql_query($sql);
			$row = $db->sql_fetchrow($res);
			$parent = $row['module_langname'];
			$class = $row['module_class'];
			$parent_id = $row['module_id'];

			if ($parent)
			{
				$link = append_sid("{$phpbb_root_path}adm/index.$phpEx", 'i=acp_modules&amp;sid=' . $user->data['session_id'] .'&amp;mode=' . $class . '&parent_id='. $parent_id .'');
				$module_mame = ($language->lang($parent) != null) ? '<b>' . $language->lang($parent) . '</b>' : '<i>' . $lang['UNDEFINED'] . '</i>';
			}
			else
			{
				$link = append_sid("{$phpbb_root_path}adm/index.$phpEx", 'i=acp_modules&amp;sid=' . $user->data['session_id'] .'&amp;mode=' . $class . '');
				$module_mame = '';
			}
			$db->sql_freeresult($res);

			$this->_section_data['acp_modules']['ITEMS'][] = array(
				'NAME'			=> '' . $module . ' (' . $module_id . ')' . $lang['GO_TO_ACP'] . ' <a href="' . $link . '" target="_blank">' . $module_mame . '</a> [' . $parent . ' (' . $parent_id . ')]',
				'FIELD_NAME'	=> $module_id,
				'MISSING'		=> false,
				'FIND'			=> append_sid("" . STK_ROOT_PATH . "finder." . PHP_EXT . "", 'm=' . $module . ''),
			);

			if ($this->_has_changes === false)
			{
				$this->_has_changes = true;
			}
		}
		$db->sql_freeresult($result);

		//Find missing modules
		foreach($modules as $module)
		{
			if (!in_array($module, $existing_modules))
			{
				$key = array_find($this->db_cleaner->data->acp_modules, $module);
				if ($key)
				{
					$parent_key = array_find($this->db_cleaner->data->acp_modules, $key);
				}
				if (isset($parent_key))
				{
					$cat_key = array_find($this->db_cleaner->data->acp_modules, $parent_key);
				}

				if($cat_key)
				{
					$mode = $cat_key;
				}

				if (!$cat_key)
				{
					$cat_key = $key;
					$mode = $parent_key;
				}

				$sql = 'SELECT module_id FROM ' . MODULES_TABLE . '
					WHERE module_langname = \'' . $key . '\'';
				$res = $db->sql_query($sql);
				$row = $db->sql_fetchrow($res);
				$parent_id = $row['module_id'];

				$db->sql_freeresult($res);

				// Link to ACP manage module
				$link = ($parent_id) ? '<a style="color:#70AED3;" href="'. append_sid("{$phpbb_root_path}adm/index.$phpEx", 'i=acp_modules&amp;sid=' . $user->data['session_id'] .'&amp;mode=' . $mode . '&parent_id=' . $parent_id . '') .'" " target="_blank">' : '';
				$module_langname = $language->lang($module);
				$parent_module_langname = $language->lang($key);

				$this->_section_data['acp_modules']['ITEMS'][] = array(
					'NAME'			=> '' . $module_langname . ' (' . $module . ')' . $lang['GO_TO_ACP'] .  $link . '' . $parent_module_langname . '</a>',
					'FIELD_NAME'	=> strtolower($module),
					'MISSING'		=> true,
				);
			}

			if ($this->_has_changes === false)
			{
				$this->_has_changes = true;
			}
		}

		$template->assign_vars(array(
			'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
		));

		$this->success_message = 'DATABASE_ROLE_DATA_SUCCESS';
		$this->not_run_message	= 'DATABASE_ROLE_DATA_SKIP';
	}

	function indexes()
	{
		global $db, $lang, $template, $phpEx, $phpbb_root_path, $umil;

		// Time to start going through the database and listing any extra/missing fields
		$last_output_table = '';
		$ignored_indexes = array('post_content', 'post_subject', 'post_text');
		foreach ($this->db_cleaner->data->tables as $table_name => $data)
		{
			if ($umil->table_exists($table_name) === false)
			{
				continue;
			}
			$existing_keys = get_keys($table_name);

			if ($existing_keys === false)
			{
				// Table doesn't exist, don't handle here.
				continue;
			}

			if (!empty($data['KEYS']))
			{
				$keys = array_unique(array_merge(array_keys($data['KEYS']), $existing_keys));
			}
			sort($keys);
			foreach ($keys as $key)
			{
				// Skip the keys added when creating search indexes of the MySQL Fulltext mechanism
				if (in_array($key, $ignored_indexes))
				{
					continue;
				}
				if ((!isset($data['KEYS'][$key]) && in_array($key, $existing_keys)) || (isset($data['KEYS'][$key]) && !in_array($key, $existing_keys)))
				{
					if ($last_output_table != $table_name)
					{
						$last_output_table = $table_name;

						$this->_section_data[$table_name] = array(
							'NAME'	=> $table_name,
							'TITLE'	=> 'INDEXES',
						);
					}

					// Add the data
					$this->_section_data[$table_name]['ITEMS'][] = array(
						'NAME'			=> $key,
						'FIELD_NAME'	=> $table_name . '_' . $key,
						'MISSING'		=> (!in_array($key, $existing_keys) || empty($existing_keys)) ? true : false,
					);

					if ($this->_has_changes === false)
					{
						$this->_has_changes = true;
					}
				}
			}
		}

		$template->assign_vars(array(
			'NO_CHANGES_TEXT'	=> $lang['SECTION_NOT_CHANGED_EXPLAIN'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
			'NO_CHANGES_TITLE'	=> $lang['SECTION_NOT_CHANGED_TITLE'][$this->db_cleaner->step_to_action[$this->db_cleaner->step]],
		));

		$this->success_message = 'DATABASE_TABLES_SUCCESS';
	}
}
