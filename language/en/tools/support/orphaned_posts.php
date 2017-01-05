<?php
/**
*
* @package Support Toolkit - Orphaned posts/topics
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
	'AUTHOR'					=> 'Author',
	'FORUM_NAME'				=> 'Forum Name',
	'NEW_TOPIC_ID'				=> 'New Topic ID',
	'POST_ID'					=> 'Post ID',
	'TOPIC_ID'					=> 'Topic ID',

	'DELETE_EMPTY_TOPICS'		=> 'Delete all selected topics by clicking on this button. (Can’t be undone!)',
	'EMPTY_TOPICS'				=> 'Empty Topics',
	'EMPTY_TOPICS_EXPLAIN'		=> 'These are topics that have no posts associated with them.',
	'NO_EMPTY_TOPICS'			=> 'No empty topics found',
	'NO_TOPICS_SELECTED'		=> 'No topics selected',

	'ORPHANED_POSTS'			=> 'Orphaned Posts',
	'ORPHANED_POSTS_EXPLAIN'	=> 'These are posts that do not have a topic associated with them. Specify a new topic ID to have the post attached to that topic.',
	'NO_ORPHANED_POSTS'			=> 'No orphaned posts found',
	'NO_TOPIC_IDS'				=> 'No topic IDs provided',
	'NONEXISTENT_TOPIC_IDS'		=> 'The following target topic IDs do not exist: %s.<br />Please verify the specified topic IDs.',
	'REASSIGN'					=> 'Reassign',

	'DELETE_SHADOWS'			=> 'Delete all selected shadow topics by clicking on this button. (Can’t be undone!)',
	'ORPHANED_SHADOWS'			=> 'Orphaned Shadow Topics',
	'ORPHANED_SHADOWS_EXPLAIN'	=> 'These are shadow topics whose target topic no longer exists.',
	'NO_ORPHANED_SHADOWS'		=> 'No orphaned shadow topics found',

	'POSTS_DELETED'				=> '%d posts deleted',
	'POSTS_REASSIGNED'			=> '%d posts re-assigned',
	'TOPICS_DELETED'			=> '%d topics deleted',
	'ORPHANED_FORUM_POSTS'			=> 'Posts not attached to the forums',
	'ORPHANED_FORUM_POSTS_EXPLAIN'	=> 'These messages are not attached to a specific forum, so it is considered that they are not attached to specific topics. Specify a new topic ID to have the post attached to that topic.',
	'NO_FORUM_ORPHANED_POSTS'		=> 'Posts which not attached to the forums not found',
	'NO_POSTS_SELECTED'				=> 'No posts selected',

	'ORPHANED_TOPICS'				=> 'Orphaned Topics',
	'NO_ORPHANED_TOPICS'			=> 'No orphaned topics found',
	'NEW_FORUM_ID'					=> 'New Forum ID',
	'TOPICS_REASSIGNED'				=> '%d topics re-assigned',
	'ORPHANED_TOPICS_EXPLAIN'		=> 'These are topics that do not have a forum associated with them. Specify a new forum ID to have the topic attached to that forum.',
	'NO_FORUMS_IDS'					=> 'No forum IDs provided',
	'NONEXISTENT_FORUMS_IDS'		=> 'The following target forums IDs do not exist: %s.<br />Please verify the specified forum IDs.',
));
