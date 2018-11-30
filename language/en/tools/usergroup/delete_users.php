<?php
/**
*
* @package Support Toolkit - Delete Usetrs English language Sheer
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
	'DELETE_USERS'				=> 'Removing users',
	'DELETE_USERS_EXPLAIN'		=> 'Here you can delete users have left no message and did not attend the board for the selected period.',
	'INACTIVE_PERIOD'			=> 'Inactivity period',
	'DELETE_USERS_SUCESS'		=> 'Users have been successfully removed.',
	'DELETE_USERS_NOT_FOUND'	=> 'Users who want to remove, not found.',
	'DELETE_USERS_CONFIRM'		=> 'Are you sure you wish to delete these users?<br />(<strong>Attention!</strong>Removal of a large number of users can take a long time. Do not leave and do not close this page up until the operation is completed.)',
));
