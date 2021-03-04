<?php
/**
*
* @package Support Toolkit
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
* Build configuration template for acp configuration pages
*
* Slightly modified from adm/index.php
*/
function build_cfg_template($tpl_type, $name, $vars)
{
	global $lang, $request;

	$tpl = array();

	if ((!isset($vars['no_request_var']) || !$vars['no_request_var']) && $tpl_type[0] != 'password')
	{
		$default = (isset($vars['default'])) ? $request->variable($name, $vars['default']) : $request->variable($name, '');
	}
	else
	{
		$default = (isset($vars['default'])) ? $vars['default'] : '';
	}

	switch ($tpl_type[0])
	{
		case 'text':
			// If requested set some vars so that we later can display the link correct
			if (isset($vars['select_user']) && $vars['select_user'] === true)
			{
				$tpl['find_user']		= true;
				$tpl['find_user_field']	= $name;
			}
		case 'password':
			$size = (int) $tpl_type[1];
			$maxlength = (int) $tpl_type[2];

			$tpl['tpl'] = '<input id="' . $name . '" type="' . $tpl_type[0] . '"' . (($size) ? ' size="' . $size . '"' : '') . ' maxlength="' . (($maxlength) ? $maxlength : 255) . '" name="' . $name . '" value="' . $default . '" />';
		break;

		case 'textarea':
			$rows = (int) $tpl_type[1];
			$cols = (int) $tpl_type[2];

			$tpl['tpl'] = '<textarea id="' . $name . '" name="' . $name . '" rows="' . $rows . '" cols="' . $cols . '">' . $default . '</textarea>';
		break;

		case 'radio':
			$name_yes	= ($default) ? ' checked="checked"' : '';
			$name_no	= (!$default) ? ' checked="checked"' : '';

			$tpl_type_cond = explode('_', $tpl_type[1]);
			$type_no = ($tpl_type_cond[0] == 'disabled' || $tpl_type_cond[0] == 'enabled') ? false : true;

			$tpl_no = '<label><input type="radio" name="' . $name . '" value="0"' . $name_no . ' class="radio" /> ' . (($type_no) ? $lang['NO'] : $lang['DISABLED']) . '</label>';
			$tpl_yes = '<label><input type="radio" id="' . $name . '" name="' . $name . '" value="1"' . $name_yes . ' class="radio" /> ' . (($type_no) ? $lang['YES'] : $lang['ENABLED']) . '</label>';

			$tpl['tpl'] = ($tpl_type_cond[0] == 'yes' || $tpl_type_cond[0] == 'enabled') ? $tpl_yes . $tpl_no : $tpl_no . $tpl_yes;
		break;

		case 'checkbox':
			$checked	= ($default) ? ' checked="checked"' : '';

			if (empty($tpl_type[1]))
			{
				$tpl['tpl'] = '<input type="checkbox" id="' . $name . '" name="' . $name . '"' . $checked . ' />';
			}
			else
			{
				$tpl['tpl'] = '<input type="radio" id="' . $name . '" name="' . $tpl_type[1] . '" value="' . $name . '"' . $checked . ' />';
			}
		break;

		case 'select':
		case 'select_multiple' :
		case 'custom':

			$return = '';

			if (isset($vars['function']))
			{
				$call = $vars['function'];
			}
			else
			{
				break;
			}

			if (isset($vars['params']))
			{
				$args = array();
				foreach ($vars['params'] as $value)
				{
					switch ($value)
					{
						case '{CONFIG_VALUE}':
							$value = $default;
						break;

						case '{KEY}':
							$value = $name;
						break;
					}

					$args[] = $value;
				}
			}
			else
			{
				$args = array($default, $name);
			}

			$return = call_user_func_array($call, $args);

			if ($tpl_type[0] == 'select')
			{
				$tpl['tpl'] = '<select id="' . $name . '" name="' . $name . '">' . $return . '</select>';
			}
			else if ($tpl_type[0] == 'select_multiple')
			{
				$tpl['tpl'] = '<select id="' . $name . '" name="' . $name . '[]" multiple="multiple">' . $return . '</select>';
			}
			else
			{
				$tpl['tpl'] = $return;
			}

		break;

		default:
		break;
	}

	if (isset($vars['append']))
	{
		$tpl['tpl'] .= $vars['append'];
	}

	return $tpl;
}

/**
* Use Lang
*
* A function for checking if a language key exists and changing the inputted var to the language value if it does.
* Build for the array_walk used on $error
*/
function use_lang(&$lang_key)
{
	global $user;

	$lang_key = user_lang($lang_key);
}

/**
* A wrapper function for the phpBB $user->lang() call. This method was introduced
* in phpBB 3.0.3. In all versions > 3.0.3 this function will simply call the method
* for the other versions this method will imitate the method as seen in 3.0.3.
*
* More advanced language substitution
* Function to mimic sprintf() with the possibility of using phpBB's language system to substitute nullar/singular/plural forms.
* Params are the language key and the parameters to be substituted.
* This function/functionality is inspired by SHS` and Ashe.
*
* Example call: <samp>$user->lang('NUM_POSTS_IN_QUEUE', 1);</samp>
*/
function user_lang()
{
	global $user, $lang;

	$args = func_get_args();

	$key = $args[0];

	// Return if language string does not exist
	if (!isset($lang[$key]) || (!is_string($lang[$key]) && !is_array($lang[$key])))
	{
		return $key;
	}

	// If the language entry is a string, we simply mimic sprintf() behaviour
	if (is_string($lang[$key]))
	{
		if (sizeof($args) == 1)
		{
			return $lang[$key];
		}

		// Replace key with language entry and simply pass along...
		$args[0] = $lang[$key];
		return call_user_func_array('sprintf', $args);
	}

	// It is an array... now handle different nullar/singular/plural forms
	$key_found = false;

	// We now get the first number passed and will select the key based upon this number
	for ($i = 1, $num_args = sizeof($args); $i < $num_args; $i++)
	{
		if (is_int($args[$i]))
		{
			$numbers = array_keys($lang[$key]);

			foreach ($numbers as $num)
			{
				if ($num > $args[$i])
				{
					break;
				}

				$key_found = $num;
			}
		}
	}

	// Ok, let's check if the key was found, else use the last entry (because it is mostly the plural form)
	if ($key_found === false)
	{
		$numbers = array_keys($lang[$key]);
		$key_found = end($numbers);
	}

	// Use the language string we determined and pass it to sprintf()
	$args[0] = $lang[$key][$key_found];
	return call_user_func_array('sprintf', $args);
}

/**
* Stk add lang
*
* @param	String	$lang_file	the name of the language file

*/
function stk_add_lang($lang_file)
{	global $template, $lang, $user, $config;

	if (empty($user->data) || !$user->data['user_lang'] || $user->data['user_id'] == 1)
	{		$default_lang = $config['default_lang'];
	}
	else
	{		$default_lang = $user->data['user_lang'];
	}

	include(PHPBB_ROOT_PATH . 'language/' . $default_lang . '/common.' . PHP_EXT);
	include(STK_ROOT_PATH . 'language/' . $default_lang . '/' . $lang_file . '.' . PHP_EXT);

	if (!defined('IN_ERK') && isset($user->data['user_id']))
	{
		foreach($lang as $key => $value)
		{
			$template->assign_var('L_' . $key, $value);
		}
	}
}

/**
 * Perform all quick tasks that has to be ran before we authenticate
 *
 * @param	String	$action	The action to perform
 * @param   bool    $submit The form has been submitted
 */
function perform_unauthed_quick_tasks($action, $submit = false)
{
	global $template, $umil, $lang, $request, $user;

	switch ($action)
	{
		// If the user wants to destroy their STK login cookie
		case 'stklogout' :
			setcookie('stk_token', '', (time() - 31536000));
			$user->unset_admin();
			meta_refresh(3, append_sid(PHPBB_ROOT_PATH . 'index.' . PHP_EXT));
			trigger_error($lang['STK_LOGOUT_SUCCESS']);
		break;

		// Can't rely on phpBB to get the phpBB version.
		case 'request_phpbb_version' :
			global $cache, $config, $phpbb_container;

			if ($config['version'] < '3.2.0')
			{
				trigger_error(sprintf($lang['STK_INCOMPATIBLE'], $config['version']), E_USER_WARNING);
			}

			$_version_number = $cache->get('_stk_phpbb_version_number');
			if ($_version_number === false)
			{
				if ($submit)
				{
					if (!check_form_key('request_phpbb_version'))
					{
						trigger_error('FORM_INVALID');
					}

					$_version_number = $request->variable('version_number', $config['version']);
					$cache->put('_stk_phpbb_version_number', $_version_number);
				}
				else
				{
					add_form_key('request_phpbb_version');
					page_header($lang['REQUEST_PHPBB_VERSION'], false);

					$version_helper = $phpbb_container->get('version_helper');
					$template->assign_vars(array(
						'CONFIG_VERSION'				=> $config['version'],
						'CONSTANT_VERSION'				=> PHPBB_VERSION,
					));
					$updates_available = $version_helper->get_suggested_updates(false);
					if ($updates_available)
					{
						foreach ($updates_available as $branch => $version_data)
						{
							$announcement = $version_data['announcement'];
						}
						// Grep the latest phpBB version number
						list(,, $_phpbb_version) = explode('.', $version_data['current']);
					}
					elseif ($config['version'] != PHPBB_VERSION)
					{
						$config['version'] = PHPBB_VERSION;
						$version_helper = $phpbb_container->get('version_helper');
						$updates_available = $version_helper->get_suggested_updates(false);
						if ($updates_available)
						{
							foreach ($updates_available as $branch => $version_data)
							{
								$announcement = $version_data['announcement'];
							}
						}
						else
						{
							$version_data['current'] = $config['version'];
						}
						list(,, $_phpbb_version) = explode('.', PHPBB_VERSION);
					}

					// Build the options
					$version_options = '';
					$v = (PHPBB_VERSION >= '3.3.0') ? "3.3.{$i}" : "3.2.{$i}";

					if ($config['version'] < PHPBB_VERSION)
					{						for ($i = $_phpbb_version; $i > 1; $i--)
						{
							$d = ($v == $config['version']) ? " default='default'" : '';
							$version_options .= "<option value='{$v}'{$d}>{$v}</option>";
						}
					}
					else
					{						list(,, $_phpbb_version) = explode('.', $version_data['current']);
						for($i = $_phpbb_version; $i > 1; $i--)
						{							$d = ($v == $config['version']) ? " default='default'" : '';
							$version_options .= "<option value='{$v}'{$d}>{$v}</option>";						}					}

					$template->assign_vars(array(
						'UPDATES_AVAILABLE'				=> (!$version_options && (PHPBB_VERSION < $version_data['current'] || $config['version'] < $version_data['current'])) ? sprintf($user->lang['UPDATES_AVAILABLE'], $version_data['current'], $announcement) : false,
						'PROCEED_TO_STK'				=> user_lang('PROCEED_TO_STK', '', ''),
						'REQUEST_PHPBB_VERSION_OPTIONS'	=> $version_options,
						'U_ACTION'						=> append_sid(STK_INDEX, array('action' => 'request_phpbb_version')),
					));

					$template->set_filenames(array(
						'body'	=> 'request_phpbb_version.html',
					));
					page_footer(false);
				}
			}
			if ($config['version'] < '3.2.0')
			{
				trigger_error(sprintf($lang['INCORRECT_PHPBB_VERSION'], $version_data['current']), E_USER_WARNING);
			}
			define('PHPBB_VERSION_NUMBER', $_version_number);
		break;

		// Check PHPBB version
		case 'check_phpbb_version' :
			check_phpbb_version();
		break;

		// Generate the passwd file
		case 'genpasswdfile' :
			// Create a 25 character alphanumeric password (easier to select with a browser and won't cause confusion like it could if it ends in "." or something).
			$_pass_string = substr(preg_replace(array('#([^a-zA-Z0-9])#', '#0#', '#O#'), array('', 'Z', 'Y'), phpbb_hash(unique_id())), 2, 25);

			// The password is usable for 6 hours from now
			$_pass_exprire = time() + 21600;

			// Print a message and tell the user what to do and where to download this page
			page_header($lang['GEN_PASS_FILE'], false);

			$template->assign_vars(array(
				'PASS_GENERATED'			=> sprintf($lang['PASS_GENERATED'], $_pass_string, $user->format_date($_pass_exprire, false, true)),
				'PASS_GENERATED_REDIRECT'	=> sprintf($lang['PASS_GENERATED_REDIRECT'], append_sid(STK_ROOT_PATH . 'index.' . PHP_EXT)),
				'S_HIDDEN_FIELDS'			=> build_hidden_fields(array('pass_string' => $_pass_string, 'pass_exp' => $_pass_exprire)),
				'U_ACTION'					=> append_sid(STK_INDEX, array('action' => 'downpasswdfile')),
			));

			$template->set_filenames(array(
				'body'	=> 'gen_password.html',
			));
			page_footer(false);
		break;

		// Download the passwd file
		case 'downpasswdfile' :
			$_pass_string	= $request->variable('pass_string', '', true);
			$_pass_exprire	= $request->variable('pass_exp', 0);

			// Something went wrong, stop execution
			if (!isset($_POST['download_passwd']) || empty($_pass_string) || $_pass_exprire <= 0)
			{
				trigger_error($lang['GEN_PASS_FAILED'], E_USER_ERROR);
			}

			// Create the file and let the user download it
			header('Content-Type: text/x-delimtext; name="passwd.' . PHP_EXT . '"');
			header('Content-disposition: attachment; filename=passwd.' . PHP_EXT);

			print ("<?php
/**
* Support Toolkit emergency password.
* The file was generated on: " . $user->format_date($_pass_exprire - 21600, 'd/M/Y H:i.s', true)) . " and will expire on: " . $user->format_date($_pass_exprire, 'd/M/Y H:i.s', true) . ".
*/

// This file can only be from inside the Support Toolkit
if (!defined('IN_PHPBB') || !defined('STK_VERSION'))
{
	exit;
}

\$stk_passwd\t\t\t\t= '{$_pass_string}';
\$stk_passwd_expiration\t= {$_pass_exprire};
";
			exit_handler();
		break;
	}
}

/**
 * Perform all quick tasks that require the user to be authenticated
 *
 * @param	String	$action	The action we'll be performing
 */
function perform_authed_quick_tasks($action)
{
	global $user;

	$logout = false;

	switch ($action)
	{
		// User wants to logout and remove the password file
		case 'delpasswdfilelogout' :
			$logout = true;

			// No Break;

		// If the user wants to distroy the passwd file
		case 'delpasswdfile' :
			if (file_exists(STK_ROOT_PATH . 'passwd.' . PHP_EXT) && false === @unlink(STK_ROOT_PATH . 'passwd.' . PHP_EXT))
			{
				// Shouldn't happen. Kill the script
				trigger_error($user->lang['FAIL_REMOVE_PASSWD'], E_USER_ERROR);
			}

			// Log him out
			if ($logout)
			{
				perform_unauthed_quick_tasks('stklogout');
			}
		break;
	}
}

/**
 * Check the STK version. If out of date
 * block access to the kit
 * @return unknown_type
 */
function stk_version_check()
{
	global $cache, $template, $umil, $user, $lang;

	// We cache the result, check once per session
	$version_check = $cache->get('_stk_version_check');
	if (!$version_check || $version_check['last_check_session'] != $user->session_id || isset($_GET['force_check']))
	{
		// Make sure that the cache file is distroyed if we got one
		if ($version_check || isset($_GET['force_check']))
		{
			$cache->destroy('_stk_version_check');
		}

		// Lets collect the latest version data. We can use UMIL for this
		$info = $umil->version_check('sheer.phpbbguru.net', '/stk', ((defined('STK_QA') && STK_QA) ? 'stk_32_qa.txt' : 'stk_32.txt'));

		// Compare it and cache the info
		$version_check = array();
		if (is_array($info) && isset($info[0]) && isset($info[1]))
		{
			if (version_compare(STK_VERSION, $info[0], '<'))
			{
				$version_check = array(
					'outdated'	=> true,
					'latest'	=> $info[0],
					'topic'		=> $info[1],
					'current'	=> STK_VERSION,
				);
			}

			$version_check['last_check_session'] = $user->session_id;

			// We've gotten some version data, cache the result for a hour or until the session id changes
			$cache->put('_stk_version_check', $version_check, 3600);
		}
	}

	// Something went wrong while retrieving the version file, lets inform the user about this, but don't kill the STK
	if (empty($version_check))
	{
		$template->assign_var('S_NO_VERSION_FILE', true);
		return;
	}
	// The STK is outdated, kill it!!!
	else if (isset($version_check['outdated']) && $version_check['outdated'] === true)
	{
		// Need to clear the $user->lang array to prevent the error page from breaking
		$msg = sprintf($lang['STK_OUTDATED'], $version_check['latest'], $version_check['current'], $version_check['topic'], append_sid(STK_ROOT_PATH . $user->page['page_name'], $user->page['query_string'] . '&amp;force_check=1'));

		// Trigger
		trigger_error($msg, E_USER_WARNING);
	}
}

/**
 * Support Toolkit Error handler
 *
 * A wrapper for the phpBB `msg_handler` function, which is mainly used
 * to update variables before calling the actual msg_handler and is able
 * to handle various special cases.
 *
 * @global type $stk_no_error
 * @global string $phpbb_root_path
 * @param type $errno
 * @param string $msg_text
 * @param type $errfile
 * @param type $errline
 * @return boolean
 */
function stk_msg_handler($errno, $msg_text, $errfile, $errline)
{
	// First and foremost handle the case where phpBB calls trigger error
	// but the STK really needs to continue.
	global $critical_repair, $stk_no_error, $user, $lang;

	if (!isset($user->lang['STK_FATAL_ERROR']))
	{
		stk_add_lang('common');
	}

	if ($stk_no_error === true)
	{
		return true;
	}

	// Do not display notices if we suppress them via @
	if (error_reporting() == 0 && $errno != E_USER_ERROR && $errno != E_USER_WARNING && $errno != E_USER_NOTICE)
	{
		return;
	}

	if (!defined('E_DEPRECATED'))
	{
		define('E_DEPRECATED', 8192);
	}

	// Ignore Strict and Deprecated notices
	if (in_array($errno, array(E_STRICT, E_DEPRECATED, E_USER_DEPRECATED)))
	{
		return true;
	}

	// We encounter an error while in the ERK, this need some special treatment

	$error_level = array(E_ERROR => 'Fatal error', E_WARNING => 'Runtime Error', E_PARSE => 'Parse error', E_NOTICE => 'Notice', );

	switch ($errno)
	{
		case E_ERROR:
		case E_PARSE:
		case E_WARNING:
		case E_NOTICE:
		case E_CORE_ERROR:
		case E_COMPILE_ERROR:
		case E_USER_ERROR:
		case E_RECOVERABLE_ERROR:
			$backtrace = get_backtrace();
			$msg_text = '<br /><b>[phpBB Debug] PHP '. $error_level[$errno] .':</b> in file ' . phpbb_filter_root_path($errfile) . ' on line <b>'. $errline .': ' . $msg_text . '</b><br />'.$backtrace.'';
		break;
		default:
		break;
	}

	if (defined('IN_ERK'))
	{
		$critical_repair->trigger_error($msg_text, ($errno == E_USER_ERROR ? false : true));
	}
	else if (!defined('IN_STK'))
	{
		// We're encountering an error before the STK is fully loaded
		// Set out own message if needed
		if ($errno == E_USER_ERROR)
		{
			$msg_text = $user->lang['STK_FATAL_ERROR'];
		}

		if (!isset($critical_repair))
		{
			include(STK_ROOT_PATH . 'includes/critical_repair.' . PHP_EXT);
			$critical_repair = new critical_repair();
		}

		$critical_repair->trigger_error($msg_text, ($errno == E_USER_ERROR ? false : true));
	}

	//-- Normal phpBB msg_handler

	global $cache, $db, $auth, $template, $config, $user;
	global $phpEx, $phpbb_root_path, $msg_title, $msg_long_text;

	// Message handler is stripping text. In case we need it, we are possible to define long text...
	if (isset($msg_long_text) && $msg_long_text && !$msg_text)
	{
		$msg_text = $msg_long_text;
	}

	if (!defined('E_DEPRECATED'))
	{
		define('E_DEPRECATED', 8192);
	}

	switch ($errno)
	{
		case E_NOTICE:
		case E_WARNING:

			// Check the error reporting level and return if the error level does not match
			// If DEBUG is defined the default level is E_ALL
			if (($errno & ((defined('DEBUG')) ? E_ALL : error_reporting())) == 0)
			{
				return;
			}

			if (strpos($errfile, 'cache') === false && strpos($errfile, 'template.') === false)
			{
				$errfile = stk_filter_root_path($errfile);
				$msg_text = stk_filter_root_path($msg_text);
				$error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice';
				$id = rand(1, 10000);
				$template->assign_block_vars('debug_r', array(
					'U_DEBUGING_ERN'	=> $error_name,
					'U_DEBUGING_ERF'	=> $errfile,
					'U_DEBUGING_ERL'	=> $errline,
					'U_DEBUGING_MSG'	=> $msg_text,
				));

				// we are writing an image - the user won't see the debug, so let's place it in the log
				if (defined('IMAGE_OUTPUT') || defined('IN_CRON'))
				{
					add_log('critical', 'LOG_IMAGE_GENERATION_ERROR', $errfile, $errline, $msg_text);
				}
			}

			return;

		break;

		case E_USER_ERROR:

			if (!empty($user) && !empty($user->lang))
			{
				$msg_text = (!empty($user->lang[$msg_text])) ? $user->lang[$msg_text] : $msg_text;
				$msg_title = (!isset($msg_title)) ? $user->lang['GENERAL_ERROR'] : ((!empty($user->lang[$msg_title])) ? $user->lang[$msg_title] : $msg_title);

				$l_return_index = sprintf($user->lang['RETURN_INDEX'], '<a href="' . $phpbb_root_path . '">', '</a>');
				$l_notify = '';

				if (!empty($config['board_contact']))
				{
					$l_notify = '<p>' . sprintf($user->lang['NOTIFY_ADMIN_EMAIL'], $config['board_contact']) . '</p>';
				}
			}
			else
			{
				$msg_title = 'General Error';
				$l_return_index = '<a href="' . $phpbb_root_path . '">Return to index page</a>';
				$l_notify = '';

				if (!empty($config['board_contact']))
				{
					$l_notify = '<p>Please notify the board administrator or webmaster: <a href="mailto:' . $config['board_contact'] . '">' . $config['board_contact'] . '</a></p>';
				}
			}

			$log_text = $msg_text;
			$backtrace = get_backtrace();
			if ($backtrace)
			{
				$log_text .= '<br /><br />BACKTRACE<br />' . $backtrace;
			}

			if (defined('IN_INSTALL') || defined('DEBUG_EXTRA') || isset($auth) && $auth->acl_get('a_'))
			{
				$msg_text = $log_text;
			}

			if ((defined('DEBUG') || defined('IN_CRON') || defined('IMAGE_OUTPUT')) && isset($db))
			{
				// let's avoid loops
				$db->sql_return_on_error(true);
				add_log('critical', 'LOG_GENERAL_ERROR', $msg_title, $log_text);
				$db->sql_return_on_error(false);
			}

			// Do not send 200 OK, but service unavailable on errors
			stk_send_status_line(503, 'Service Unavailable');

			garbage_collection();

			// Try to not call the adm page data...

			echo '<!DOCTYPE html>';
			echo "\r\n";
			echo '<html dir="' . $user->lang['DIRECTION'] . '" lang="' . $user->lang['USER_LANG'] . '">';
			echo "\r\n";
			echo '<head>';
			echo '<meta charset="utf-8">';
			echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
			echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
			echo '<title>' . $msg_title . '</title>';
			echo '<style type="text/css">' . "\n" . '/* <![CDATA[ */' . "\n";
			echo '* { margin: 0; padding: 0; } html { font-size: 100%; height: 100%; margin-bottom: 1px; background-color: #E4EDF0; } body { font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif; color: #536482; background: #E4EDF0; font-size: 62.5%; margin: 0; } ';
			echo 'a:link, a:active, a:visited { color: #006699; text-decoration: none; } a:hover { color: #DD6900; text-decoration: underline; } ';
			echo '#wrap { padding: 0 20px 15px 20px; min-width: 615px; } #page-header { text-align: right; height: 40px; } #page-footer { clear: both; font-size: 1em; text-align: center; } ';
			echo '.panel { margin: 4px 0; background-color: #FFFFFF; border: solid 1px  #A9B8C2; } ';
			echo '#errorpage #page-header a { font-weight: bold; line-height: 6em; } #errorpage #content { padding: 10px; } #errorpage #content h1 { line-height: 1.2em; margin-bottom: 0; color: #DF075C; } ';
			echo '#errorpage #content div { margin-top: 20px; margin-bottom: 5px; border-bottom: 1px solid #CCCCCC; padding-bottom: 5px; color: #333333; font: bold 1.2em "Lucida Grande", Arial, Helvetica, sans-serif; text-decoration: none; line-height: 120%; text-align: left; } ';
			echo "\n" . '/* ]]> */' . "\n";
			echo '</style>';
			echo '</head>';
			echo '<body id="errorpage">';
			echo '<div id="wrap">';
			echo '	<div id="page-header">';
			echo '		' . $l_return_index;
			echo '	</div>';
			echo '	<div id="acp">';
			echo '	<div class="panel">';
			echo '		<div id="content">';
			echo '			<h1>' . $msg_title . '</h1>';

			echo '			<div>' . $msg_text . '</div>';

			echo $l_notify;

			echo '		</div>';
			echo '	</div>';
			echo '	</div>';
			echo '	<div id="page-footer">';
			echo '		Powered by <a href="https://www.phpbb.com/">phpBB</a>&reg; Forum Software &copy; phpBB Group';
			echo '	</div>';
			echo '</div>';
			echo '</body>';
			echo '</html>';

			exit_handler();

			// On a fatal error (and E_USER_ERROR *is* fatal) we never want other scripts to continue and force an exit here.
			exit;
		break;

		case E_USER_WARNING:
		case E_USER_NOTICE:
			define('IN_ERROR_HANDLER', true);

			if (empty($user->data))
			{
				$user->session_begin();
			}

			// We re-init the auth array to get correct results on login/logout
			$auth->acl($user->data);

			if (empty($user->lang))
			{
				$user->setup();
			}

			if ($msg_text == 'ERROR_NO_ATTACHMENT' || $msg_text == 'NO_FORUM' || $msg_text == 'NO_TOPIC' || $msg_text == 'NO_USER')
			{
				stk_send_status_line(404, 'Not Found');
			}

			$msg_text = (!empty($user->lang[$msg_text])) ? $user->lang[$msg_text] : $msg_text;
			$msg_title = (!isset($msg_title)) ? $lang['INFORMATION'] : ((!empty($lang[$msg_title])) ? $lang[$msg_title] : $msg_title);

			if (!defined('HEADER_INC'))
			{
				if (defined('IN_ADMIN') && isset($user->data['session_admin']) && $user->data['session_admin'])
				{
					adm_page_header($msg_title);
				}
				else
				{
					page_header($msg_title, false);
				}
			}

			// Do not use the normal template path (to prevent issues with boards using alternate styles)
			$template->set_custom_style('stk', STK_ROOT_PATH . 'style');

			$template->set_filenames(array(
				'body' => 'message_body.html')
			);

			$template->assign_vars(array(
				'MESSAGE_TITLE'		=> $msg_title,
				'MESSAGE_TEXT'		=> $msg_text,
				'S_USER_WARNING'	=> ($errno == E_USER_WARNING) ? true : false,
				'S_USER_NOTICE'		=> ($errno == E_USER_NOTICE) ? true : false)
			);

			// We do not want the cron script to be called on error messages
			define('IN_CRON', true);

			if (defined('IN_ADMIN') && isset($user->data['session_admin']) && $user->data['session_admin'])
			{
				adm_page_footer();
			}
			else
			{
				page_footer();
			}

			exit_handler();
		break;

		// PHP4 compatibility
		case E_DEPRECATED:
			return true;
		break;
	}

	// If we notice an error not handled here we pass this back to PHP by returning false
	// This may not work for all php versions
	return false;
}

//-- Wrappers for functions that only exist in newer php version
if (!function_exists('array_fill_keys'))
{
	/**
	* Fills an array with the value of the value parameter, using the values of the keys array as keys.
	* @param Array $keys Array of values that will be used as keys. Illegal values for key will be converted to string.
	* @param mixed $value Value to use for filling
	*/
	function array_fill_keys($keys, $value)
	{
		$array = array();

		foreach ($keys as $key)
		{
			$array[$key] = $value;
		}

		return $array;
	}
}

if (!function_exists('adm_back_link'))
{
	/**
	* Generate back link for acp pages
	*/
	function adm_back_link($u_action)
	{
		return '<br /><br /><a href="' . $u_action . '">&laquo; ' . user_lang('BACK_TO_PREV') . '</a>';
	}
}

/**
* Removes absolute path to phpBB root directory from error messages
* and converts backslashes to forward slashes.
*
* @param string $errfile	Absolute file path
*							(e.g. /var/www/phpbb3/phpBB/includes/functions.php)
*							Please note that if $errfile is outside of the phpBB root,
*							the root path will not be found and can not be filtered.
* @return string			Relative file path
*							(e.g. /includes/functions.php)
*/
function stk_filter_root_path($errfile)
{
	static $root_path;

	if (empty($root_path))
	{
		$root_path = phpbb_realpath(dirname(__FILE__) . '/../');
	}

	return str_replace(array($root_path, '\\'), array('[ROOT]', '/'), $errfile);
}

// php.net, laurynas dot butkus at gmail dot com, http://us.php.net/manual/en/function.html-entity-decode.php#75153
function html_entity_decode_utf8($string)
{
	static $trans_tbl;

	// replace numeric entities
	$string = preg_replace_callback(
		'|&#x([0-9a-f]+)|',
		function ($matches) { return _code2utf8(hexdec($matches[1])); },
		$string
	);

	$string = preg_replace_callback(
		'|&#([0-9]+);|',
		function ($matches) { return _code2utf8($matches[1]); },
		$string
	);

	// replace literal entities
	if (!isset($trans_tbl))
	{
		$trans_tbl = array();

		foreach (get_html_translation_table(HTML_ENTITIES) as $val => $key)
		{
			$trans_tbl[$key] = utf8_encode($val);
		}
	}

	return strtr($string, $trans_tbl);
}

// Returns the utf string corresponding to the unicode value (from php.net, courtesy - romans@void.lv)
function _code2utf8($num)
{
	$return = '';

	if ($num < 128)
	{
		$return = chr($num);
	}
	else if ($num < 2048)
	{
		$return = chr(($num >> 6) + 192) . chr(($num & 63) + 128);
	}
	else if ($num < 65536)
	{
		$return = chr(($num >> 12) + 224) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
	}
	else if ($num < 2097152)
	{
		$return = chr(($num >> 18) + 240) . chr((($num >> 12) & 63) + 128) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
	}

	return $return;
}

/**
* wrapper for pathinfo($file, PATHINFO_FILENAME), as PATHINFO_FILENAME is
* php > 5.2
* Function by php [spat] hm2k.org (http://www.php.net/manual/en/function.pathinfo.php#88159)
 */
function pathinfo_filename($file) { //file.name.ext, returns file.name
	if (defined('PATHINFO_FILENAME'))
	{
		return pathinfo($file, PATHINFO_FILENAME);
	}

	if (strstr($file, '.'))
	{
		return substr($file, 0, strrpos($file, '.'));
	}
}

/**
 * A function that behaves like `array_walk` but instead
 * of walking over the values this function walks
 * over the keys
 */
function stk_array_walk_keys(&$array, $callback)
{
	if (!is_callable($callback))
	{
		return;
	}

	$tmp_array = array();
	foreach ($array as $key => $null)
	{
		$walked_key = call_user_func($callback, $key);
		$tmp_array[$walked_key] = $array[$key];
		unset($array[$key]);
	}
	$array = $tmp_array;
}

/**
* Outputs correct status line header.
*
* Depending on php sapi one of the two following forms is used:
*
* Status: 404 Not Found
*
* HTTP/1.x 404 Not Found
*
* HTTP version is taken from HTTP_VERSION environment variable,
* and defaults to 1.0.
*
* Sample usage:
*
* send_status_line(404, 'Not Found');
*
* @param int $code HTTP status code
* @param string $message Message for the status code
* @return void
*/
function stk_send_status_line($code, $message)
{
	global $request;

	$server_protocol = $request->server('SERVER_PROTOCOL');
	if (substr(strtolower(@php_sapi_name()), 0, 3) === 'cgi')
	{
		// in theory, we shouldn't need that due to php doing it. Reality offers a differing opinion, though
		header("Status: $code $message", true, $code);
	}
	else
	{
		if (!empty($server_protocol))
		{
			$version = $server_protocol;
		}
		else
		{
			$version = 'HTTP/1.0';
		}
		header("$version $code $message", true, $code);
	}
}

// Check PHPBB version
function check_phpbb_version()
{
	global $phpbb_container, $template, $config, $lang;

	$version_helper = $phpbb_container->get('version_helper');
	$updates_available = $version_helper->get_suggested_updates(false);
	if ($updates_available)
	{
		foreach ($updates_available as $branch => $version_data)
		{
			$announcement = $version_data['announcement'];
			$version = $version_data['current'];
		}

		$template->assign_vars(array(
			'UPDATES_AVAILABLE'		=> (PHPBB_VERSION < $version_data['current'] || $config['version'] < $version_data['current']) ? sprintf($lang['UPDATES_AVAILABLE'], $version_data['current'], $announcement) : false,
		));
	}
}

function sinc_stats()
{
	global $db, $config;

	$sql = 'SELECT COUNT(post_id) AS stat
		FROM ' . POSTS_TABLE . '
		WHERE post_visibility = ' . ITEM_APPROVED;
	$result = $db->sql_query($sql);
	$config->set('num_posts', (int) $db->sql_fetchfield('stat'), false);
	$db->sql_freeresult($result);

	$sql = 'SELECT COUNT(topic_id) AS stat
		FROM ' . TOPICS_TABLE . '
		WHERE topic_visibility = ' . ITEM_APPROVED;
	$result = $db->sql_query($sql);
	$config->set('num_topics', (int) $db->sql_fetchfield('stat'), false);
	$db->sql_freeresult($result);

	$sql = 'SELECT COUNT(attach_id) as stat
		FROM ' . ATTACHMENTS_TABLE . '
		WHERE is_orphan = 0';
	$result = $db->sql_query($sql);
	$config->set('num_files', (int) $db->sql_fetchfield('stat'), false);
	$db->sql_freeresult($result);

	$sql = 'SELECT SUM(filesize) as stat
		FROM ' . ATTACHMENTS_TABLE . '
		WHERE is_orphan = 0';
	$result = $db->sql_query($sql);
	$config->set('upload_dir_size', (float) $db->sql_fetchfield('stat'), false);
	$db->sql_freeresult($result);
}

/**
* Get all the groups for the groups dropdown.
*/
function get_groups()
{
	global $lang;
	static $option_list = null;
	$args = func_get_args();

	// Only run this once
	if ($option_list == null)
	{
		global $db, $user;

		// Just ignore the BOTS and GUESTS groups
		$group_ignore = array('BOTS', 'GUESTS');

		// Get the groups and build the dropdown list
		$sql = 'SELECT group_id, group_type, group_name
			FROM ' . GROUPS_TABLE . '
			WHERE ' . $db->sql_in_set('group_name', $group_ignore, true);
		$result = $db->sql_query($sql);

		$option_list = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$selected	= ($row['group_name'] == 'REGISTERED') ? 'selected=selected' : '';
			$group_name = (($row['group_type'] == GROUP_SPECIAL) && isset($lang['G_' . $row['group_name']])) ? $lang['G_' . $row['group_name']] : $row['group_name'];
			$option_list .= "<option value='{$row['group_id']}'{$selected}>{$group_name}</option>";
		}

		$db->sql_freeresult($result);
	}

	// Remove the selected statement if we are displaying the leaderships group list
	if (isset($args[1]))
	{
		if ($args[1] == 'groupleader')
		{
			return str_replace('selected=selected', '', $option_list);
		}
	}

	return $option_list;
}

function delete_style($style)
{
	global $db, $lang, $config;

	$id = $style['style_id'];
	$path = $style['style_path'];
	$default_style = $config['default_style'];

	// Check if style has child styles
	$sql = 'SELECT style_id, style_path, style_name, style_parent_id
		FROM ' . STYLES_TABLE . '
		WHERE style_parent_id = ' . (int) $id . " OR style_parent_tree = '" . $db->sql_escape($path) . "'";
	$result = $db->sql_query($sql);

	$conflict = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if ($conflict !== false)
	{
		// try to delete parent
		if (!delete_style($conflict))
		{
			return sprintf($lang['STYLE_UNINSTALL_DEPENDENT'], $style['style_name']);
		}
	}

	// Change default style for users
	$sql = 'UPDATE ' . USERS_TABLE . '
		SET user_style = ' . (int) $default_style . '
		WHERE user_style = ' . $id;
	$db->sql_query($sql);

	// Uninstall style
	$sql = 'DELETE FROM ' . STYLES_TABLE . '
		WHERE style_id = ' . $id;
	$db->sql_query($sql);

	delete_files($path);
	return true;
}

function delete_files($path, $dir = '')
{
	$styles_path = '' . PHPBB_ROOT_PATH . 'styles/';
	$dirname = $styles_path . $path . $dir;
	$result = true;

	$dp = @opendir($dirname);

	if ($dp)
	{
		while (($file = readdir($dp)) !== false)
		{
			if ($file == '.' || $file == '..')
			{
				continue;
			}
			$filename = $dirname . '/' . $file;
			if (is_dir($filename))
			{
				if (!delete_files($path, $dir . '/' . $file))
				{
					$result = false;
				}
			}
			else
			{
				if (!@unlink($filename))
				{
					$result = false;
				}
			}
		}
		closedir($dp);
	}
	if (!@rmdir($dirname))
	{
		return false;
	}

	return $result;
}
function output($msg)
{
	global $template;

	$template->assign_vars(array(
		'OUTPUT'	=> $msg,
	));
}

