<?php
/**
*
* @package Support Toolkit - phpbb English language Sheer
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

/**
* DO NOT CHANGE
*/
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
	'MANAGE_EXT'				=> 'Manage extension\'s files',
	'EXT_NAME'					=> 'Extension name',
	'EXTENSIONS_FILES'			=> 'File extensions',
	'EXTENSIONS_FILES_EXPLAIN'	=> 'Here you can view, rename, delete, or create new files or folders of your extensions.',
	'EXPAND'					=> 'Expand/Collapse',
	'SAVE'						=> 'Save',
	'SAVED'						=> 'File %s has been successfully saved',
	'EDITED'					=> 'File %s has been successfully changed',
	'FAIL_CREATE_FILE'			=> 'Failed to create file %s',
	'FAIL_EXISTS'				=> 'File %s already exists',
	'FAIL_CREATE_DIR'			=> 'Failed to create folder %s',
	'ADD_NEW'					=> 'Add new file',
	'PATH'						=> 'Path relative to the folder %s/',
	'PATH_EXPLAIN'				=> 'If folder does not exist, it will be created',
	'FILE'						=> 'File name',
	'CONTENT'					=> 'Code',
	'EXT_PATH'					=> 'Path relative to the folder ' . PHPBB_ROOT_PATH . 'ext/',
	'DELETE'					=> 'Delete',
	'RENAME'					=> 'Rename',
	'DELETE_OK'					=> 'File %s has been successfully removed',
	'DELETE_FAIL'				=> 'Failed to remove file %s',
	'DELETE_FOLDER_OK'			=> 'Folder %s has been successfully removed',
	'DELETE_FOLDER_FAIL'		=> 'Failed to delete folder %s',
	'NEW_NAME'					=> 'New fie name',
	'RENAME_OK'					=> 'File %1s has been successfully renamed to %2s',
	'RENAME_FAIL'				=> 'Failed to rename file %s',
	'RENAME_FOLDER_OK'			=> 'Folder %1s has been successfully renamed to %2s',
	'RENAME_FOLDER_FAIL'		=> 'Failed to rename folder %s',

	'ENABLED'					=> 'Active',
	'DISABLED'					=> 'Disabled',
	'NOT_INSTALLED'				=> 'Not installed',
	'NO_EXTENSIONS_FILES'		=> '<strong>Files not found</strong>.<br />Probably not installed any extensions, either missing files and folders installed extensions.',
));
