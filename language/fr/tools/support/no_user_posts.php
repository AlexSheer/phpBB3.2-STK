<?php
/**
*
* @package Support Toolkit - No User Posts English language
* @version $Id$
* @copyright (c) 2019 Sheer
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
	'NO_USER_POSTS'					=> 'Posts without author',
	'NO_USER_POSTS_EXPLAIN'			=> 'This tool allows you to delete posts of non-existent authors (this can happen if users were manually deleted directly from the database, and not using regular phpBB tools).',
	'AUTHOR_POSTS_REASSIGNED'		=> 'Authors assigned to %d posts.',
	'NO_NO_USER_POSTS'				=> 'No posts from non-existent authors',
	'NO_AUTHOR_SELECTED'			=> 'No author assigned.',
	'POSTS_REASSIGNED_TO_GUEST'		=> 'For %d posts, <b>Anonymous</b> has been assigned as author.',
	'REASSIGN_ANONYMOUS'			=> 'Assign Anonymous as author to selected posts',
));
