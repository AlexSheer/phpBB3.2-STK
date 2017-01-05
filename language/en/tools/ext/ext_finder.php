<?php
/**
*
* @package Support Toolkit - Ext Finder English language Sheer
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
	'EXT_TABLE_FINDER'			=> 'Tables',
	'EXT_TABLE_FINDER_EXPLAIN'	=> 'Here you can get information about an extension, which uses this table:',
	'TABLE'						=> 'Table',

	'EXT_COLUMN_FINDER'			=> 'Columns',
	'EXT_COLUMN_FINDER_EXPLAIN'	=> 'Here you can get information about an extension, which uses this column:',
	'COLUMN'					=> 'Column',

	'EXT_CONFIG_FINDER'			=> 'Configs',
	'EXT_CONFIG_FINDER_EXPLAIN'	=> 'Here you can get information about an extension, which uses this config parameter:',
	'CONFIG'					=> 'Parameter',

	'EXT_MODULE_FINDER'			=> 'Modules',
	'EXT_MODULE_FINDER_EXPLAIN'	=> 'Here you can get information about an extension, which uses this module:',
	'MODULE'					=> 'Module',

	'EXT_PERM_FINDER'			=> 'Permissions',
	'EXT_PERM_FINDER_EXPLAIN'	=> 'Here you can get information about an extension, which uses this permission:',
	'PERMISSION'				=> 'Permission',

	'PATH'				=> 'PATH, RELATED ./ext',
	'INFO'				=> 'INFO (name/version  - description)',
	'NOT_IN_EXT'		=> '<em>Element is not part of any expansion, the appointment is unknown</em>',

	'EXTRA_EXPLAIN'		=> 'the status of the extension, its name, version and brief description. Active extension <b style="color: #282">highlighted in green</b>.',
));
