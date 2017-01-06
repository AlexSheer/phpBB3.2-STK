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

// Under certain circumstances it is possible that this file
// is included twice. (Bug #62660)
if (!class_exists('database_cleaner'))
{
	class database_cleaner
	{
		/**
		* @var Array An array that is used to link step numbers with the action. Used to call the correct methods
		*/
		var $step_to_action = array(
			'introduction',
			'tables',
			'indexes',
			'columns',
			'config',
			'extension_groups',
			'extensions',
			'permissions',
			'groups',
			'roles',
			'role_data',
			'acp_modules',
			'modules',
			'bots',
			'report_reasons',
			'final_step',
		);

		/**
		* @var database_cleaner_data The database cleaner data object
		*/
		var $data = null;

		/**
		* @var mixed Contains the views or controller object, depending on what is going on
		*/
		var $object = null;

		/**
		* @var String phpBB version number
		*/
		var $phpbb_version = '';

		/**
		* @var Integer The step that is being ran
		*/
		var $step = 0;

		/**
		* Do we have a datafile for this version?
		*/
		function tool_active()
		{
			global $config;

			// Correctly format the version number. Only RC releases are in uppercase
			if (!defined('PHPBB_VERSION_NUMBER'))
			{
				define('PHPBB_VERSION_NUMBER', PHPBB_VERSION);
			}
			$this->phpbb_version = str_replace(array('.', '-', 'rc'), array('_', '_', 'RC'), strtolower(PHPBB_VERSION_NUMBER));

			// Unstable versions can only be used when debugging
			$matches = array();
			if (preg_match('#^([0-9_]+)_(a|b|dev|RC([0-9]*))$#i', $this->phpbb_version, $matches))
			{
				if (!defined('DEBUG'))
				{
					return 'UNSTABLE_DEBUG_ONLY';
				}
				else if (!empty($matches[1]))
				{
					// Get rid of any unstable identifiers
					$this->phpbb_version = $matches[1];
				}
			}

			// Data file exists?
			if (file_exists(STK_ROOT_PATH . 'includes/database_cleaner/data/' . $this->phpbb_version . '.' . PHP_EXT) === false)
			{
				return 'DATAFILE_NOT_FOUND';
			}

			return true;
		}

		/**
		* Correctly setup the database cleaner
		*/
		function _setup()
		{
			global $db, $request;

			$next = $request->variable('next', false);
			$next_step = $request->variable('next_step', 0);
			$quit = $request->variable('quit', false);
			if ($quit)
			{
				 $this->quit();
			}
			// Skip next step & redirect to specified step
			if ($next)
			{
				redirect(append_sid(STK_INDEX, array('c' => 'support', 't' => 'database_cleaner', 'step' => $next_step)));
			}

			// Get the step.
			// If the step is outside the $this->step_to_action range set it to 0
			$this->step = $request->variable('step', 0);
			if ($this->step < 0 || $this->step > sizeof($this->step_to_action))
			{
				$this->step = 0;
			}

			// include the required file for this version
			if (!function_exists('fetch_cleaner_data'))
			{
				include STK_ROOT_PATH . 'includes/database_cleaner/functions_database_cleaner.' . PHP_EXT;
			}

			if (!class_exists('database_cleaner_data'))
			{
				include STK_ROOT_PATH . 'includes/database_cleaner/database_cleaner_data.' . PHP_EXT;
			}

			if (!class_exists('phpbb\db\tools\tools'))
			{
				include PHPBB_ROOT_PATH . 'phpbb/db/tools/tools.' . PHP_EXT;
			}
			$db_tools = new phpbb\db\tools\tools($db);

			// Load all data for this version
			$this->data = new database_cleaner_data($db_tools);
			fetch_cleaner_data($this->data, $this->phpbb_version);
		}

		/**
		* Display the correct confirmation screen
		*/
		function display_options()
		{
			global $template, $user;

			// Setup
			$this->_setup();
			$user->add_lang('acp/common');

			// Setup $this->object
			if (!class_exists('database_cleaner_views'))
			{
				include STK_ROOT_PATH . 'includes/database_cleaner/database_cleaner_views.' . PHP_EXT;
			}
			$this->object = new database_cleaner_views($this);

			// Call the correct view method
			call_user_func(array($this->object, $this->step_to_action[$this->step]));

			// Output the page
			$this->object->display();
		}

		/**
		* Perform the right actions
		* @param Array $error An array that will be filled with error messages that might occure
		* @return void
		*/
		function run_tool(&$error)
		{
			global $request;

			// Setup
			$this->_setup();
			// Skip this step & did no any action
			$skip = $request->variable('skip', false);
			if ($skip)
			{
				redirect(append_sid(STK_INDEX, array('c' => 'support', 't' => 'database_cleaner', 'step' => $this->step + 1)));
			}

			$selected = $request->variable('items', array('' => ''), true);

			if ($this->step > 0 && !check_form_key('database_cleaner'))
			{
				// Kick them if bad form key
				$error[] = 'FORM_INVALID';
				return;
			}

			// Setup $this->object
			if (!class_exists('database_cleaner_controller'))
			{
				include STK_ROOT_PATH . 'includes/database_cleaner/database_cleaner_controller.' . PHP_EXT;
			}
			$this->object = new database_cleaner_controller($this);

			// Call the correct method
			$error = call_user_func(array($this->object, $this->step_to_action[$this->step]), $error, $selected);

			// Error?
			if (!empty($error))
			{
				return;
			}

			// Confirm boxes
			$did_run = true;
			if (!isset($_POST['yes']))
			{
				$did_run = false;
			}

			// Redirect to the next step
			redirect(append_sid(STK_INDEX, array('c' => 'support', 't' => 'database_cleaner', 'step' => $this->step + 1, 'did_run' => $did_run)));
		}

		function quit()
		{
			global $umil, $lang, $config;

			$umil->cache_purge();
			$umil->cache_purge('auth');

			$config->set('board_disable', 0);
			$config->set('board_disable_msg', '');

			// Finished!
			trigger_error($lang['DATABASE_CLEANER_BREAK'], E_USER_WARNING);
		}

	}
}
