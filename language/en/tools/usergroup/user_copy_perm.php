<?php
/**
*
* @package Support Toolkit - User Options English language Sheer
* @version $Id$
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @
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
	'USER_COPY_PERM'					=> 'Copy user\'s permissions',
	'USER_COPY_PERM_EXPLAIN'			=> 'Note that will be copied to all permissions: users, moderators, administrators and local.',
	'COPY_USER_PERMISSIONS_EXPLAIN'		=> 'Select user whose permissions will be copied',
	'COPY_USER_PERMISSIONS_OK'			=> 'Permissions successfully copied.',
	'USERS_IDENTICAL'					=> 'It is not possible to transfer permissions.',
	'FIND_FROM_USER'					=> 'Username whose permissions will be copied',
	'ID_FROM'							=> 'User ID whose permissions will be copied',
	'FIND_TO_USER'						=> 'Username that you want to transfer permissions',
	'ID_TO'								=> 'User ID that you want to transfer permissions',
));
