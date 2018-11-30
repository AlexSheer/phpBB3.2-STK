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
	'ACP_EXTENSION_GROUPS'			=> 'Attachment extensions groups',
	'ACP_MODULES_SETTINGS'			=> 'Search for additional modules',

	'BOARD_DISABLE_REASON'			=> 'The board is currently disabled due to some database maintenance. Please check back soon!',
	'BOARD_DISABLE_SUCCESS'			=> 'The board has been disabled successfully!',

	'COLUMNS'						=> 'Columns',
	'CONFIG_SETTINGS'				=> 'Configuration Settings',
	'CONFIG_UPDATE_SUCCESS'			=> 'The configuration settings have been updated successfully!',
	'CONTINUE'						=> 'Continue',

	'DATABASE_CLEANER'				=> 'Database Cleaner',
	'DATABASE_CLEANER_BREAK'		=> 'Database Cleaner forcibly interrupted work!<br /><br />The cache has been cleaned and restored access to the board.',
	'DATABASE_CLEANER_EXTRA'		=> 'Any others are extra items added by modifications.  <strong>If the check box is selected it will be removed</strong>.',
	'DATABASE_CLEANER_MISSING'		=> 'Any fields with a red background like this are missing items that should be added.  <strong>If the check box is selected it will be added</strong>.',
	'DATABASE_CLEANER_SUCCESS'		=> 'The database cleaner has successfully finished all tasks!<br /><br />Please be sure to backup your database again.',
	'DATABASE_CLEANER_WARNING'		=> 'This tool comes with NO WARRANTY and users of this tool should back up their entire database in case of a failure.<br /><br />Before continuing, make sure you have a database backup!',
	'DATABASE_CLEANER_WELCOME'		=> 'Welcome to the Database Cleaner tool!<br /><br />This tool was designed to remove extra columns, rows, and tables from the database not present in the default installation of phpBB3, and to add missing database elements that may be needed.<br /><br />When you are ready to continue click the Continue button to start using the Database Cleaner tool (note that your board will be disabled until this is finished).',
	'DATABASE_COLUMNS_SUCCESS'		=> 'The database columns have been updated successfully!',
	'DATABASE_INDEXES_SUCCESS'		=> 'Indexes updated successfully!',
	'DATABASE_TABLES'				=> 'Database Tables',
	'DATABASE_TABLES_SUCCESS'		=> 'The database tables have been updated successfully!',
	'DATABASE_ROLE_DATA_SKIP'		=> 'Reinstalling system roles ignored',
	'DATABASE_ROLE_DATA_SUCCESS'	=> 'The phpBB system roles were restored successfully!',
	'DATABASE_ROLES_SUCCESS'		=> 'The roles were updated successfully!',
	'DATAFILE_NOT_FOUND'			=> 'The Support Toolkit couldn’t find the required data-file for your phpBB version!',

	'EMPTY_PREFIX'					=> 'No database prefix',
	'EMPTY_PREFIX_CONFIRM'			=> 'The database cleaner is about to make changes to the tables in your database, but as you are using an empty table prefix this might affect non-phpBB tables. Are you sure that you want to continue?',
	'EMPTY_PREFIX_EXPLAIN'			=> 'The database cleaner has determined that you haven\'t set an table prefix for the phpBB database tables. Due to this the database cleaner will check <strong>all</strong> tables in the database. Take extra care when proceeding and make sure that you exclude any non-phpBB tables from the selection. Failing to do so will damage database tables that aren\'t part of phpBB.<br />If you aren\'t sure on how to proceed seek assistance in the <a href="http://www.phpbb.com/community/viewforum.php?f=46">phpBB Support Forums</a>.',
	'ERROR'							=> 'Error',
	'EXTRA'							=> 'Extra',
	'EXTENSION_FILE_GROUPS'			=> 'Attachment extension',
	'EXTENSION_GROUPS_SETTINGS'		=> 'Extension groups settings',
	'EXTENSION_GROUPS_SUCCESS'		=> 'The extension groups have been reset successfully',
	'EXTENSIONS_SUCCESS'			=> 'The extensions have been reset successfully',

	'FINAL_STEP'					=> 'This is the final step.<br /><br />We will now re-enable your board and purge your board’s cache.',

	'GO_TO_ACP'						=> ' --&raquo; go to control module ',

	'INSTRUCTIONS'					=> 'Instructions',
	'INTRODUCTION'					=> 'Start over',
	'INDEXES'						=> 'DB Tables Indexes',

	'MISSING'						=> 'Missing',
	'MODULE_ADD'					=> 'Module add',
	'MODULE_ALREADY_EXIST'			=> 'Module already exist',
	'MODULE_UPDATE_SUCCESS'			=> 'The modules have been updated successfully!',

	'NEXT_STEP'						=> 'Next step',
	'NO_BOT_GROUP'					=> 'Could not reset the bots, missing Bot group.',
	'NO_PARENT'						=> 'Parent module not exists.<br />Failed',

	'PERMISSION_SETTINGS'			=> 'Permission Options',
	'PERMISSION_UPDATE_SUCCESS'		=> 'The permission settings have been updated successfully!',
	'PHPBB_VERSION_NOT_SUPPORTED'	=> 'Your version of phpBB3 is not supported (or some files from the Support Toolkit are missing).<br />phpBB 3.0.0+ should be supported, but it may take some time for this tool to be updated following the release of a new version of phpBB 3.0.',

	'QUIT'							=> 'Quit',

	'RESET_ACP_MODULES_SKIP'		=> 'Checking of additional modules skipped',
	'RESET_ACP_MODULE_SUCCESS'		=> 'Checking of additional modules is done',
	'RESET_BOTS'					=> 'Reset Bots',
	'RESET_BOTS_EXPLAIN'			=> 'Would you like to reset the bots list to the default phpBB3 bot list?  All existing bots will be removed and be replaced with the default set.',
	'RESET_BOTS_SKIP'				=> 'The bot reset has been skipped',
	'RESET_BOT_SUCCESS'				=> 'The bots have been reset successfully!',
	'RESET_MODULES'					=> 'Reset Modules',
	'RESET_MODULES_EXPLAIN'			=> 'Would you like to reset the modules to the default phpBB3 modules? All existing modules will be removed and be replaced with the default ones.',
	'RESET_MODULES_SKIP'			=> 'The module reset has been skipped',
	'RESET_MODULE_SUCCESS'			=> 'The modules have been reset successfully!',
	'RESET_REPORT_REASONS'			=> 'Reset report reasons',
	'RESET_REPORT_REASONS_EXPLAIN'	=> 'Would you like to reset the report reasons to the default? This will remove all added report reasons!',
	'RESET_REPORT_REASONS_SKIP'		=> 'The report reasons haven\'t been reset',
	'RESET_REPORT_REASONS_SUCCESS'	=> 'The report reasons have successfully been reset!',
	'RESET_ROLE_DATA'				=> 'Reset role data',
	'RESET_ROLE_DATA_EXPLAIN'		=> 'This step will reset the phpBB system roles back to their original state, its highly advised to run this if you made changes in the previous step.',
	'ROLE_SETTINGS'					=> 'Role Settings',
	'ROWS'							=> 'Rows',

	'SECTION_NOT_CHANGED_TITLE'		=> array(
		'tables'			=> 'Tables not changed',
		'indexes'			=> 'Indexes not changed',
		'columns'			=> 'Columns not changed',
		'config'			=> 'Config not changed',
		'extension_groups'	=> 'Extension groups not changed',
		'extensions'		=> 'Extensions not changed',
		'permissions'		=> 'Permissions not changed',
		'groups'			=> 'Groups not changed',
		'roles'				=> 'Roles not changed',
		'final_step'		=> 'Final step',
		'acp_modules'		=> 'Search for additional or missing modules',
	),
	'SECTION_NOT_CHANGED_EXPLAIN'	=> array(
		'tables'			=> 'The database tables haven’t been changed',
		'indexes'			=> 'Indexes doesn’t have any new/missing values',
		'columns'			=> 'The columns in the database haven’t been changed',
		'config'			=> 'The configuration table doesn’t have any new/missing values',
		'extension_groups'	=> 'The extension groups table doesn’t have any new/missing values',
		'extensions'		=> 'The default extensions haven\'t changed',
		'permissions'		=> 'There were no changes in the permission tables',
		'groups'			=> 'There were no changes in the phpBB system groups',
		'roles'				=> 'There were no roles added or removed',
		'final_step'		=> 'This last step will clear the cache and re-enable the board.',
		'acp_modules'		=> 'Not found any additional or missing modules',
	),
	'SKIP_AND_GO'					=> 'Skip & Go',
	'SKIP_TO'						=> 'Skip',
	'SKIP_EXPLAIN'					=> 'You can skip actions on this step and go to step selected from the list below:',
	'SUCCESS'						=> 'Success',
	'SYSTEM_GROUPS'					=> 'Checking system groups',
	'SYSTEM_GROUP_UPDATE_SUCCESS'	=> 'The system groups have been reset successfully',

	'TYPE'							=> 'Type',

	'UNSTABLE_DEBUG_ONLY'			=> 'The database cleaner can only run on unstable phpBB versions <em>(dev, a, b, RC)</em>, when "DEBUG" is enabled through the phpBB config file.',
	'UNDEFINED'						=> 'undefined',

	'ARCHIVES'				=> 'Archives',
	'DOCUMENTS'				=> 'Documents',
	'DOWNLOADABLE_FILES'	=> 'Downloadable files',
	'FLASH_FILES'			=> 'Flash files',
	'IMAGES'				=> 'Images',
	'PLAIN_TEXT'			=> 'Plain text files',
	'QUICKTIME_MEDIA'		=> 'Quicktime files',
	'REAL_MEDIA'			=> 'RealMedia files',
	'WINDOWS_MEDIA'			=> 'Windows Media files',
));
