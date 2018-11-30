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
	'USERS_NOGROUPS'			=> 'Users without groups',
	'USERS_NOGROUPS_EXPLAIN'	=> 'This is a list of users who for some reason do not belong to any of the groups established at the conference.
								You can mark any user and assign him a default group, as well as another group or groups, in which the user will enter.',
	'LOST_GROUPS_USERS'			=> 'Users who do not belong to any groups',
	'NO_USERS_FOUND'			=> 'No users were found belonging to any groups',
	'NO_USERS_SELECTED'			=> 'You must select at least one user.',
	'ASSIGHN_GROUPS_SUCCESS'	=> 'Selected users were successfully added to the group (s).',
));
