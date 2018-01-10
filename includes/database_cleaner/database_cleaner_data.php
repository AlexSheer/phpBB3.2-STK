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
* Data class containing all data for the cleaner
*/
class database_cleaner_data
{
	/**
	* @var Array The bots
	*/
	var $bots = array();

	/**
	* @var Array The config array for this version
	*/
	var $config = array();

	/**
	* @var Array The permissions array for this version
	*/
	var $acl_options = array();

	/**
	* @var Array The roles array for this version
	*/
	var $acl_roles = array();

	/**
	* @var Array The role data array for this version
	* This array contains the data needed to build the queries as
	* found in `schemas/schema_data.sql`
	*/
	var $acl_role_data = array();

	/**
	* @var Array All default extension groups
	*/
	var $extension_groups = array();

	/**
	* @var Array All default extensions
	*/
	var $extensions = array();

	/**
	* @var Array array holding the module categorie structure
	*/
	var $module_categories = array();

	/**
	* @var Array Module extra data
	*/
	var $module_extras = array();

	/**
	* @var Array The groups array for this version
	*/
	var $groups = array();

	/**
	* @var Array The schema struct
	*/
	var $schema_data = array();

	/**
	* @var Array An array containing all tables that are included in a vanilla phpBB install of this version
	*/
	var $tables = array();

	/**
	* @var Array An array containing all report reasons
	*/
	var $report_reasons = array();
	/**
	* @var Array An array containing all ACP modules
	*/
	var $acp_modules = array();

	/**
	* @var Array An array containing basenames for ACP modules
	*/
	var $module_categories_basenames = array();

	/**
	* @var Array Config entries that were removed
	*/
	var $removed_config = array();

	/**
	* Some data needs to be adjusted in certain cases
	*/
	function init()
	{
		// Extract tables
		global $table_prefix, $db;

		$this->tables = $this->schema_data;

		// Get the right table prefix!
		if ($table_prefix != 'phpbb_')
		{
			foreach ($this->tables as $table_name => $table_data)
			{
				unset($this->tables[$table_name]);
				$this->tables[str_replace('phpbb_', $table_prefix, $table_name)] = $table_data;
			}
		}

		// Oracle, need the table and column names in
		// UPPERCASE. #62821
		switch ($db->get_sql_layer())
		{
			case 'oracle'	:
				// Uppercase the table names
				stk_array_walk_keys($this->tables, 'strtoupper');

				// Loop into the data structure to alter the columns
				foreach ($this->tables as $table => $null)
				{
					stk_array_walk_keys($this->tables[$table]['COLUMNS'], 'strtoupper');
				}
			break;
		}
	}
}
