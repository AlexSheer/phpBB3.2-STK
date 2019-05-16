<?php
/**
*
* @package Support Toolkit - Clear Extensions English language
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
	'CLEAR_EXTENSIONS'				=> 'Verification and management extensions',
	'CLEAR_EXTENSIONS_EXPLAIN'		=> 'Here you can manage <strong>installed</strong> extensions.',
	'EXT_PATH'						=> 'Path relative to the folder ' . PHPBB_ROOT_PATH . 'ext/',
	'MISSING_PATH'					=> 'Missing folder',
	'S_ACTIVE'						=> ' (active) ',
	'S_OFF'							=> ' (disabled) ',
	'EXT_NAME'						=> 'Extension name',
	'CLICK_TO_CLEAR'				=> 'Records of selected installed extensions will be deleted from database and extension are disabled, but data related to these extensions, such as tables or configuration values, remain. To delete them, use the <b>SUPPORT TOOLS</b> -> Database Cleaner',
	'CLICK_TO_OFF'					=> 'Selected extensions will be disabled',
	'OFF_EXT'						=> 'Turn off',
	'CLEAR_EXT_SUCCESS'				=> 'Selected extensions successfully removed.',
	'CLICK_TO_ON'					=> 'Selected extensions will be enabled.',
	'ON_EXT'						=> 'Turn on',
	'ON_EXT_SUCCESS'				=> 'Selected extensions successfully enabled.',
	'OFF_EXT_SUCCESS'				=> 'Selected extensions successfully disabled.',
	'NO_EXT_SELECTED'				=> 'Nothing selected!',
	'EXT_DELETE'					=> 'Remove extension',
	'EXT_DELETE_CONFIRM'			=> 'Are you sure you want to delete these extensions?',
	'EXT_OFF'						=> 'Disable extensions',
	'EXT_OFF_CONFIRM'				=> 'Are you sure you want to disable these extensions?',
	'EXT_MISSING_PATH'				=> 'Extension «%s» is not compatible.<br />',
	'NO_COMPOSER'					=> 'File not found: ' . PHPBB_ROOT_PATH . 'ext/%s/composer.json',
	'NO_EXTENSIONS_TITLE'			=> 'Extensions',
	'NO_EXTENSIONS_TEXT'			=> 'No any installed extensions',
	'VERSION_CHECK_FAIL'			=> 'Failed to obtain latest version information'
));
