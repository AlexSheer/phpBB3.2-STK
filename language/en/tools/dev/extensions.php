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
	'EXTENSIONS'			=> 'Develop extensions',
	'EXTENSIONS_EXPLAIN'	=> 'Creating a workpiece extension. After performing the necessary actions will be established minimum extension structure. To create a full-fledged extension you need to edit the generated files and add new ones that will be required for the extension.',
	'DEVELOPER'				=> 'Name (nickname) Developer',
	'DEVELOPER_EXPLAIN'		=> 'This is the name of the extension, which will be displayed in the ACP in tab <strong>&laquo;Customise-->Extensions Manager-->Details&raquo;</strong> together with other optional parameters that you can enter below.',
	'AUTHOR_EXPLAIN'		=> 'Vendor name.<br />In folder ./ext/ folder will be created (if it does not already exist) with the same name as this parameter. All extensions of the author must be inside this folder. The names of folders not allowed hyphens, and underscores. In the name of the vendor should be at least 3 characters.',
	'EXT_EXPLAIN'			=> 'Extension name.<br />In folder ./ext/_vendor_name_/ folder will be created with the same name as this parameter. All folders and files of this extension will be placed inside this folder. The name of the extension should be at least 3 characters.',
	'DISPLAY_NAME'			=> 'Display Name',
	'DESCRIPTION'			=> 'Description',
	'VERSION'				=> 'Version of the extension',
	'DESCRIPTION_EXPLAIN'	=> 'Brief description of the expansion.',
	'ROLE'					=> 'Developer role',
	'ROLE_EXPLAIN'			=> 'A brief description of the author\'s contribution to the development of expansion.',
	'HOMEPAGE'				=> 'Developer\'s web site',

	'EMPTY_VENDOR'			=> 'No vendor name',
	'EMPTY_EXT_NAME'		=> 'Name of extension is not specified',
	'EMPTY_AUTHOR'			=> 'No Developer name (nickname)',
	'EMPTY_DISPLAY_NAME'	=> 'No Display Name',
	'EMPTY_VERSION'			=> 'Version is not specified',
	'VENDOR_NAME_TOO_SHORT'	=> 'Vendor name must be at least 3 characters long.',
	'EXT_NAME_TOO_SHORT'	=> 'Extension name must be at least 3 characters long.',

	'ARE_REQUIRED'			=> '<hr>Fields marked with * are required.',
	'SUCCESS'				=> 'Workpiece of extension successfully created. Now you can start real creation of extension.',
	'ALREADY_EXISTS'		=> 'This extension already exists!',
));
