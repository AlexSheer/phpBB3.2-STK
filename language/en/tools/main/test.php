<?php
/**
*
* @package Support Toolkit - Test English language Sheer
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
	'TEST'				=> 'General Information',
	'DATABASE_INFO'		=> 'Database server',
	'DBMS'				=> 'Database type',
	'PHP_INFO'			=> 'Information about php',
	'PHP_VERSION'		=> 'PHP version',
	'STK_VERSION'		=> 'Support Tookit version',
	'MBSTRING_LOADED'	=> 'Functions for working with multi-byte strings (PHP extension <strong>mbstring</strong>) is loaded',
	'MBSTRING_NOT_LOADED'				=> 'Functions for working with multi-byte strings (PHP extension <strong>mbstring</strong>) not loaded',
	'ERROR_MBSTRING_NOT_LOADED_EXPLAIN'	=> 'mbstring is not included in the list of extensions that are installed by default. This means that initially this extension is disabled. To use the functions of this extension, you must explicitly enable the module to configure php. Need to consult the documentation for <a href="http://php.net/manual/ru/mbstring.configuration.php">PHP</a>.',
));
