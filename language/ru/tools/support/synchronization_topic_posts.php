<?php
/**
*
* @package Support Toolkit - Synchronization topics/posts Russian language Sheer
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
	'SYNCHRONIZATION_TOPIC_POSTS'			=> 'Синхронизация тем',
	'SYNCHRONIZATION_TOPIC_POSTS_EXPLAIN'	=> 'Этот инструмент позволяет восстановить реальное количество сообщений в таблице <em>_topics</em>.',
	'TOPICS_NOT_SYNCHRONIZED'				=> 'Темы, требующие синхронизации',
	'TOPIC_ID'								=> 'ID темы',
	'TOPIC_TOTAL_POSTS'						=> 'Общее кол-во сообщений<br />из таблицы %s',
	'TOPIC_TOTAL_POSTS_TITLE'				=> 'одобренные сообщения +  ожидающие одобрения + удаленные',
	'POSTS_TOTAL'							=> 'Реальное кол-во сообщений<br />из таблицы %s',
	'FROM_TABLE'							=> '<br />из таблицы %s',
	'NO_NOT_SYNCHRONIZED_TOPICS'			=> 'Тем не обнаружено',
	'SYNCHRONIZING_TOPICS'					=> 'Синхронизировать',
	'TOPIC_LAST_POST_ID'					=> 'ID последнего сообщения',
	'MAX_POST_ID'							=> 'Последний ID сообщения',
	'TOPICS_SINCRONIZED'					=> 'Было синхронизировано тем: %d',
));
