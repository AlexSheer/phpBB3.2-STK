<?php
/**
*
* @package Support Toolkit - Synchronization topics/posts English language Sheer
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
	'SYNCHRONIZATION_TOPIC_POSTS'			=> 'Topics synchronization',
	'SYNCHRONIZATION_TOPIC_POSTS_EXPLAIN'	=> 'This tool allows you to recover the actual number of posts in the table <em>_topics</em>.',
	'TOPICS_NOT_SYNCHRONIZED'				=> 'Topics that require synchronization',
	'TOPIC_ID'								=> 'Topic ID',
	'TOPIC_TOTAL_POSTS'						=> 'Total number of posts<br />from table %s',
	'TOPIC_TOTAL_POSTS_TITLE'				=> 'approved +  unapproved + deleted',
	'POSTS_TOTAL'							=> 'Actual number of posts<br />from table %s',
	'FROM_TABLE'							=> '<br />from table %s',
	'NO_NOT_SYNCHRONIZED_TOPICS'			=> 'Not found',
	'SYNCHRONIZING_TOPICS'					=> 'Synchronize',
	'TOPIC_LAST_POST_ID'					=> 'Last post ID',
	'MAX_POST_ID'							=> 'Last ID',
	'TOPICS_SINCRONIZED'					=> '%d was synchronized successfully',
));
