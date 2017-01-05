<?php
/**
*
* @package Support Toolkit - Readd Module Management
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

class readd_module_management
{
	/**
	 * The modules this class will check and re-add and/or enable if required.
	 * The array contains all information we feed into $umil->module_exists and $umil->module_add
	 */
	var $check_modules = array(
		array(
			'class' 	=> 'acp',
			'parent'	=> 0,
			'lang_name'	=> 'ACP_CAT_SYSTEM'
		),
		array(
			'class'		=> 'acp',
			'parent'	=> 'ACP_CAT_SYSTEM',
			'lang_name'	=> 'ACP_MODULE_MANAGEMENT'
		),
		array(
			'class'		=> 'acp',
			'parent'	=> 'ACP_MODULE_MANAGEMENT',
			'lang_name'	=> 'ACP',
			'data'		=> array(
				'module_basename'	=> 'acp_modules',
				'modes'				=> array('acp'),
			),
		),
		array(
			'class'		=> 'acp',
			'parent'	=> 'ACP_MODULE_MANAGEMENT',
			'lang_name'	=> 'MCP',
			'data'		=> array(
				'module_basename'	=> 'acp_modules',
				'modes'				=> array('mcp'),
			),
		),
		array(
			'class'		=> 'acp',
			'parent'	=> 'ACP_MODULE_MANAGEMENT',
			'lang_name'	=> 'UCP',
			'data'		=> array(
				'module_basename'	=> 'acp_modules',
				'modes'				=> array('ucp'),
			),
		),
	);

	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		return 'READD_MODULE_MANAGEMENT';
	}

	/**
	* Run Tool
	*
	* Does the actual stuff we want the tool to do after submission
	*/
	function run_tool()
	{
		global $cache, $db, $umil;

		// Check all modules for existance
		foreach ($this->check_modules as $module_data)
		{
			if(!$umil->module_exists($module_data['class'], $module_data['parent'], $module_data['lang_name']))
			{
				$this->module_add($module_data['lang_name'], $module_data['class'], $module_data['parent'], ((empty($module_data['data'])) ? $module_data['lang_name'] : $module_data['data']));
			}

			// This module exists, now make sure that it is enabled
			$sql = 'SELECT module_id
				FROM ' . MODULES_TABLE . "
				WHERE module_class = '" . $db->sql_escape($module_data['class']) . "'
					AND module_langname = '" . $db->sql_escape($module_data['lang_name']) . "'
					AND module_enabled = 1";
			$result		= $db->sql_query_limit($sql, 1, 0);
			$enabled	= $db->sql_fetchfield('module_id', false, $result);
			$db->sql_freeresult($result);

			if (!$enabled)
			{
				// Enable it
				$sql = 'UPDATE ' . MODULES_TABLE . "
					SET module_enabled = 1
					WHERE module_class = '" . $db->sql_escape($module_data['class']) . "'
						AND module_langname = '" . $db->sql_escape($module_data['lang_name']) . "'";
				$db->sql_query($sql);
			}
		}

		$cache->destroy('_modules_acp');
		trigger_error(user_lang('READD_MODULE_MANAGEMENT_SUCCESS'));
	}

	function module_add($lang_name, $class, $parent, $module_data)
	{		print "$lang_name, $class, $parent<br />";
		print"<pre>"; print_r($module_data); print"</pre>";		global $db, $phpbb_root_path, $phpEx, $user;

		$sql = 'SELECT module_id
			FROM ' . MODULES_TABLE . '
			WHERE module_langname LIKE \'' . $parent . '\'';
		$result		= $db->sql_query_limit($sql, 1, 0);
		$parent_id = $db->sql_fetchfield('module_id', false, $result);
		$db->sql_freeresult($result);

		$module_data = array(
			'module_enabled'	=> 1,
			'module_display'	=> 1,
			'module_basename'	=> $module_data['module_basename'],
			'module_class'		=> $class,
			'parent_id'			=> $parent_id,
			'module_langname'	=> $lang_name,
			'module_mode'		=> $module_data['modes'][0],
			'module_auth'		=> 'acl_a_modules',
		);

		if (!class_exists('acp_modules'))
		{
			include($phpbb_root_path . 'includes/acp/acp_modules.' . $phpEx);
			$user->add_lang('acp/modules');
		}
		$acp_modules = new acp_modules();
		$result = $acp_modules->update_module_data($module_data, true);

		if (is_string($result))
		{
			// Error
			trigger_error($user->lang['NO_MODULE'], E_USER_WARNING);
		}
	}
}
