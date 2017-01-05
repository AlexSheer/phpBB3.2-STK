<?php
/**
*
* @package Support Toolkit - Orphaned posts/topics Russian language Sheer
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
	'AUTHOR'					=> 'Автор',
	'FORUM_NAME'				=> 'Название форума',
	'NEW_TOPIC_ID'				=> 'ID новой темы',
	'POST_ID'					=> 'ID сообщения',
	'TOPIC_ID'					=> 'ID темы',

	'DELETE_EMPTY_TOPICS'		=> 'Удалить выбранные темы нажатием на кнопку. (Действие необратимо!)',
	'EMPTY_TOPICS'				=> 'Пустые (испорченные) темы',
	'EMPTY_TOPICS_EXPLAIN'		=> 'Это темы, в которых нет сообщений или это ссылки на пропавшие темы.',
	'NO_EMPTY_TOPICS'			=> 'Пустых (испорченных) тем не найдено',
	'NO_TOPICS_SELECTED'		=> 'Нет выбранных тем',

	'ORPHANED_POSTS'			=> 'Одиночные сообщения (не приписанные к темам)',
	'ORPHANED_POSTS_EXPLAIN'	=> 'Эти сообщения не привязаны к конкретным темам. Укажите ID темы-родителя, к которой необходимо привязать потерянные сообщения.',
	'NO_ORPHANED_POSTS'			=> 'Одиночные сообщения (не приписанные к темам) не найдены',
	'NO_TOPIC_IDS'				=> 'Не указаны идентификаторы тем-родителей',
	'NONEXISTENT_TOPIC_IDS'		=> 'Тем-родителей с указанными идентификаторами не существует: %s.<br />Пожалуйста, проверьте корректность идентификаторов тем.',
	'REASSIGN'					=> 'Переназначить',

	'DELETE_SHADOWS'			=> 'Удалить выбранные ссылки на пропавшие темы нажатием на кнопку. (Действие не обратимо!)',
	'ORPHANED_SHADOWS'			=> 'Ссылки на пропавшие темы',
	'ORPHANED_SHADOWS_EXPLAIN'	=> 'Это ссылки на несуществующие темы.',
	'NO_ORPHANED_SHADOWS'		=> 'Ссылок на пропавшие темы не обнаружено',

	'POSTS_DELETED'				=> '%d сообщений удалено',
	'POSTS_REASSIGNED'			=> '%d сообщений восстановлено в темах-родителях',
	'TOPICS_DELETED'			=> '%d тем удалено',
	'ORPHANED_FORUM_POSTS'			=> 'Сообщения не приписанные к форумам',
	'ORPHANED_FORUM_POSTS_EXPLAIN'	=> 'Эти сообщения не привязаны к конкретным форумам, поэтому считается, что они также не привязаны к конкретным темам. Укажите ID темы-родителя, к которой необходимо привязать эти сообщения.',
	'NO_FORUM_ORPHANED_POSTS'		=> 'Сообщения, не приписанные к форумам, не найдены',
	'NO_POSTS_SELECTED'				=> 'Ничего не выбрано',

	'ORPHANED_TOPICS'				=> 'Несуществующие темы',
	'NO_ORPHANED_TOPICS'			=> 'Несуществующих тем не обнаружено',
	'NEW_FORUM_ID'					=> 'ID нового форума',
	'TOPICS_REASSIGNED'				=> '%d сообщений восстановлено в форумах-родителях',
	'ORPHANED_TOPICS_EXPLAIN'		=> 'Это темы, приписанные к несуществующим форумам. Укажите ID форума-родителя, к которому необходимо привязать потерянные темы.',
	'NO_FORUMS_IDS'					=> 'Не указаны идентификаторы форумов-родителей',
	'NONEXISTENT_FORUMS_IDS'		=> 'Форумы-родители с указанными идентификаторами не существуют: %s.<br />Пожалуйста, проверьте корректность идентификаторов форумов.',
));
