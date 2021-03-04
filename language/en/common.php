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
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
   exit;
}

if (empty($lang) || !is_array($lang))
{
   $lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'BACK_TOOL'							=> 'Back to last tool',
	'BOARD_FOUNDER_ONLY'				=> 'Only Board Founders may access the Support Toolkit.',

	'CAT_ADMIN'							=> 'Admin Tools',
	'CAT_ADMIN_EXPLAIN'					=> 'Administrative Tools may be used by an administrator to manage particular aspects of their forum and solve common problems.',
	'CAT_DEV'							=> 'Developer Tools',
	'CAT_DEV_EXPLAIN'					=> 'Developer Tools may be used by phpBB Developers and MODders to perform common tasks.',
	'CAT_ERK'							=> 'Emergency Repair Kit',
	'CAT_ERK_EXPLAIN'					=> 'The emergency repair kit is a seperate package of the STK that is build to run some checks that can detect issues within your phpBB install that might prevent your board from working. Click <a href="%s">here</a> to run the ERK.',
	'CAT_MAIN'							=> 'Main',
	'CAT_MAIN_EXPLAIN'					=> 'The Support Toolkit (STK) may be used to fix common issues within a working installation of phpBB 3.2.x. It serves as a second Administration Control Panel, providing an administrator with a set of tools to resolve common problems that may prevent a phpBB3 installation from functioning properly.',
	'CAT_SUPPORT'						=> 'Support Tools',
	'CAT_SUPPORT_EXPLAIN'				=> 'Support Tools may be used to aid in the recovery of a phpBB 3.2.x installation that is no longer functioning properly.',
	'CAT_USERGROUP'						=> 'User/Group Tools',
	'CAT_USERGROUP_EXPLAIN'				=> 'User and Group Tools may be used to manage users and groups in ways that are not available in a stock phpBB 3.2.x installation.',
	'CONFIG_NOT_FOUND'					=> 'The STK configuration file couldn’t be loaded. Please check your installation',
	'CONFIG_VERSION'					=> 'Version number in Database',
	'CONSTANT_VERSION'					=> 'Version number in /includes/constants.php',

	'DOWNLOAD_PASS'						=> 'Download the password file.',
	'STK_PASSWORD'						=> 'Password',

	'EMERGENCY_LOGIN_NAME'				=> 'STK Emergency Login',
	'ERK'								=> 'Emergency Repair Kit',

	'FAIL'								=> 'Fail',
	'FAIL_REMOVE_PASSWD'				=> 'Couldn’t remove the expired password file. Please remove this file manually!',

	'GEN_PASS_FAILED'					=> 'The Support Toolkit was unable to generate a new password. Please try again.',
	'GEN_PASS_FILE'						=> 'Generate password file.',
	'GEN_PASS_FILE_EXPLAIN'				=> 'If you aren’t able to login to phpBB you can use the internal authentication method of the Support Toolkit. To use this method you must <a href="%s"><strong>generate</strong></a> a new password file.',

	'INCORRECT_CLASS'					=> 'Incorrect class in: stk/tools/%1$s.%2$s',
	'INCORRECT_PASSWORD'				=> 'Password is incorrect',
	'INCORRECT_PHPBB_VERSION'			=> 'Your version of phpBB isn’t compatible with this tool. Your phpBB installation must be version %1$s or later in order to run this tool.',

	'LOGIN_STK_SUCCESS'					=> 'You have successfully authenticated and will now be redirected to the Support Toolkit.',

	'NOTICE'							=> 'Notice',
	'NO_VERSION_FILE'					=> 'The Support Toolkit (STK) was not able to determine the latest version. Please go to the <a href="http://phpbb.com/support/stk">Support Toolkit section of phpBB.com</a> and verify that you are using the latest version before using the STK.',

	'REQUEST_PHPBB_VERSION'				=> 'Define phpBB version',
	'REQUEST_PHPBB_VERSION_EXPLAIN'		=> 'The Support Toolkit was unable to correctly identify which phpBB version you are running, please select the appropriate version in this form before continuing.<br />This indicates that your board files and board version are inconsistent, most likely due to an incomplete update. Please visit the <a href="https://www.phpbb.com/community/viewforum.php?f=46">support forums</a> to get assistance to resolve this issue.',

	'PASS_GENERATED'					=> 'Your STK password file was successfully generated!<br/>The password that was generated for you is: <em>%1$s</em><br />This password will expire on: <span style="text-decoration: underline;">%2$s</span>. After this time you <strong>must</strong> generate a new password file in order to keep using the emergency login feature!<br /><br />Use the following button to download the file. Once you’ve downloaded this file you must upload it to your server into the "stk" directory',
	'PASS_GENERATED_REDIRECT'			=> 'Once you have uploaded the password file to the correct location, click <a href="%s">here</a> to go back to the login page.',
	'PLUGIN_INCOMPATIBLE_PHPBB_VERSION'	=> 'This tool isn’t compatible with the version of phpBB that you are running',
	'PROCEED_TO_STK'					=> '%sProceed to the Support Toolkit%s',

	'STK_FOUNDER_ONLY'					=> 'You must re-authenticate yourself before you can use the Support Toolkit.',
	'STK_LOGIN'							=> 'Support Toolkit Login',
	'STK_LOGIN_WAIT'					=> 'You must wait three seconds before re-attempting login. Please try again.',
	'STK_LOGOUT'						=> 'STK Logout',
	'STK_LOGOUT_SUCCESS'				=> 'You have successfully logged out from the Support Toolkit.',
	'STK_NON_LOGIN'						=> 'Login to access the STK.',
	'STK_OUTDATED'						=> 'Your Support Toolkit installation appears to be out of date. The latest available version is <strong style="color: #008000;">%1$s</strong>, while the version your have installed is <strong style="color: #FF0000;">%2$s</strong>.<br /><br />Due to the large impact of this tool on your phpBB installation, it has been disabled until an update is performed. We strongly recommend keeping all software running on your server up to date. For more information regarding the latest update, please see the <a href="%3$s">release topic</a>.<br /><br /><em>If you see this notice after an update of the Support Toolkit, click <a href="%4$s">here</a> to clear the version check cache.</em>',
	'SUPPORT_TOOL_KIT'					=> 'Support Toolkit',
	'SUPPORT_TOOL_KIT_INDEX'			=> 'Support Toolkit Index',
	'SUPPORT_TOOL_KIT_PASSWORD'			=> 'Password',
	'SUPPORT_TOOL_KIT_PASSWORD_EXPLAIN'	=> 'Since you are not logged in to phpBB3 you must verify that you are a board founder by entering the Support Toolkit Password.<br /><br /><strong>Cookies MUST be allowed by your browser or you will not be able to stay logged in.</strong>',

	'TOOL_INCLUTION_NOT_FOUND'			=> 'This tool is attempting to load a file (%1$s) that does not exist.',
	'TOOL_NAME'							=> 'Tool Name',
	'TOOL_NOT_AVAILABLE'				=> 'The requested tool is not available.',

	'USING_STK_LOGIN'					=> 'You are logged in using the internal STK authentication method. It is advised to use this method <strong>only</strong> when you are unable to login to phpBB.<br />To disable this authentication method click <a href="%1$s">here</a>.',
	'VISITED'							=> 'Last visit',
	'TOTAL'								=> 'Total',

	'ERK_OK'							=> 'The Emergency Repair Kit hasn\'t found any critical issues within your phpBB installation.',
	'RELOAD_STK'						=> 'Click <a href="%s"><b>here</b></a> to reload STK.',
	'RELOAD_ARK'						=> 'Click <a href="%s"><b>here</b></a> to reload ARK.',
	'ANONYMOUS_MISSING'					=> 'Support Toolkit determined that Anonymous user is missing in your database, so your board can\'t function properly.<br />
											Click <a href="%s"><b>here</b></a> and go to Emergency Repair Kit - Anonymous user will be automatically restored.',

	'ERK_NO_WHITELIST'					=> 'The BOM sniffer couldn\'t read the whitelist, and can\'t run the tests. Please seek assistance in the <a href="%s">Support Forums</a>.',
	'ERK_ISSUE_FOUND'					=> 'As part of the “Emergency Repair Kit” of the Support Toolkit the ERK has checked your phpBB files and determined that some of the files contain invalid content that potentially could stop the board from operating. The Support Toolkit has tried to resolve these issues and created a package with the corrected files <em>(backed up versions can be found in <c>store/bom_sniffer_backup/</c>)</em>. This package is stored in the <c>store/bom_sniffer/</c> directory. To apply the changed files to your board please <strong>move</strong> the files from the “store” to their correct location and load the Support Toolkit again. The toolkit will check these files again and will redirect you to the ERK if no flaws are found.<br /><br /><strong style="color: #ff0000;">Before moving the generated files, please make sure that the generated files are correct!</strong> When in doubt please seek assistance in the <a href="http://www.phpbb.com/community/viewforum.php?f=46">support forum</a>.',
	'ERK_STORE_WRITE'					=> 'The BOM sniffer requires the <c>store</c> directory to exist and to be writable!',
	'ERK_REMOVE_DIR'					=> 'The Support Toolkit has tried to remove the repaired file storage directory of this tool but wasn\'t able to do so. In order for this tool to run correctly the \'<c>%s</c>\' must be removed from the server. Please remove this directory manually and release the Support Toolkit.',
	'BOM_SNIFFER_WRITABLE'				=> 'The BOM sniffer requires the ' . STK_ROOT_PATH . 'cache directory to exist and to be writable!',
	'STK_FATAL_ERROR'					=> '<strong style="color: #ff0000;">The Support Toolkit encountered a fatal error.</strong><br /><br />
											 The Support Toolkit includes an Emergency Repair Kit (ERK), a tool designed to resolve certain errors that prevent phpBB from functioning.
											 It is advised that you run the ERK now so it can attempt to repair the error it has detected.<br />
											 To run the ERK, click <a href="' . STK_ROOT_PATH . 'erk.' . PHP_EXT . '"><b>here</b></a>.',
	'CONFIG_REPAIR'						=> 'Repair config.php',
	'CONFIG_REPAIR_EXPLAIN'				=> 'Through this tool you can regenerate your configuration file',
	'CONFIG_REPAIR_NO_TABLES'			=> 'phpBB3 tables could not be found on this database with this table prefix.',
	'CONFIG_REPAIR_NO_DBMS'				=> 'Unable to determine any suitable type of database.',
	'CONFIG_REPAIR_CONNECT_FAIL'		=> 'Database Connection failed.',
	'CONFIG_REPAIR_WRITE_ERROR'			=> '<strong style="color: #ff0000;">ERROR: Could not write config file.</strong><br />Please copy the text below, put it in a file named config.php, and place it in the root directory of your forum.<br /><br />',

	'CONFIG_LIST'						=> 'Configuration parameters',
	'CONFIG_LIST_EXPLAIN'				=> 'Here you can view and change the configuration .',
	'CLOSE'								=> 'Close',
	'UPDATES_AVAILABLE'					=> 'Your version of phpBB is not the latest. Available version for updates is %1$s<br />Follow this link <a href="%2$s" target="_blank" />%2$s</a> to the release announcement for the latest version, which contains additional information, as well as instructions for updating phpBB',
	'VERSIONCHECK_FAIL'					=> 'Failed to obtain latest phpBB version information.',

	'SELECT_ALL'						=> 'To select all, move cursor in field below and press Ctrl-A (PC), Cmd-A (Mac) <br />Double click selects a word and triple entire row.',

	'PURGE_CACHE'						=> 'Purge the cache',
	'PURGE_CACHE_CONFIRM'				=> 'Are you sure you wish to purge the cache?',
	'USERNAME'							=> 'Username',
	'PASSWORD'							=> 'Password',
	'SUBMIT'							=> 'Submit',
	'CANCEL'							=> 'Cancel',
	'FORUM_INDEX'						=> 'Board index',

	'FILE_WRITE_FAIL'					=> 'Failed to write file',
	'STK_INCOMPATIBLE'					=> 'This STK version is dedicated to phpBB 3.2.x boards, while your phpBB version is %1$s.',

	'PHPBB_DEBUG'					=> '[phpBB Debug]',
	'DEBUG_IN_FILE'					=> 'in file',
	'DEBUG_ON_LINE'					=> 'on line',
));
