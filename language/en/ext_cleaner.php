<?php
/**
*
* @package Support Toolkit Russian language Sheer
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
	'CLEAR_EXTENSIONS'			=> 'Verify and manage extensions',
	'CLEAR_EXTENSIONS_EXPLAIN'	=> 'Here you can disable/enable or remove <strong>installed</strong> extensions.',
	'EXT_PATH'					=> 'Path relative to the folder ' . PHPBB_ROOT_PATH . 'ext/',
	'MISSING_PATH'				=> 'Missing folder ',
	'S_ACTIVE'					=> ' (enabled) ',
	'S_OFF'						=> ' (disabled) ',
	'EXT_NAME'					=> 'Extension Name',
	'CLICK_TO_CLEAR'			=> 'Records of selected installed extensions will be deleted from the database and the extensions will be disabled, however, data related to these extensions, such as tables or configuration values, will remain.',
	'CLICK_TO_OFF'				=> 'Selected extensions will be disabled. When the extension is disabled, its files, data and settings will remain,<br />but the functionality added by this extension is deleted.',
	'OFF_EXT'					=> 'Disable',
	'CLEAR_EXT_SUCCESS'			=> 'Selected extensions was deleted successfully.',
	'OFF_EXT_SUCCESS'			=> 'Selected extensions was disabled successfully.',
	'ON_EXT_SUCCESS'			=> 'Selected extensions was enabled successfully.',
	'NO_EXT_SELECTED'			=> 'Nothing selected!',
	'EXT_DELETE'				=> 'Remove Extensions',
	'EXT_OFF'					=> 'Disable Extensions',
	'EXT_MISSING_PATH'			=> 'The «%s» extension is not valid.<br />',
	'NO_COMPOSER'				=> 'The requested file could not be found: ' . PHPBB_ROOT_PATH . 'ext/%s/composer.json',
	'NO_EXTENSIONS_TITLE'		=> 'Extensions',
	'NO_EXTENSIONS_TEXT'		=> 'No installed extensions found',
	'OFF_EXT'					=> 'Disable',
	'ON_EXT'					=> 'Enable',
	'NO_EXT_SELECTED'			=> 'Nothing selected!',
	'CLICK_TO_ON'				=> 'Selected extensions will be included.',
	'EMPTY_PASSWD'				=> 'You cannot login without a password',
	'WRONG_PASSWD'				=> 'Incorrect password',
	'DB_CONNECT_ERROR'			=> 'Connection error: %s',
	'DB_CONNECT_PASS_ERROR'		=> 'Connection error:',
	'TABLE_NOT_EXISTS'			=> 'The database table prefix is ​​probably incorrect or the table does not exist.',
));
