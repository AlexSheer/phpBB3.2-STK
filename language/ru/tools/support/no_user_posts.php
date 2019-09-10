<?php
/**
*
* @package Support Toolkit - No User Posts Russian language
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
	'NO_USER_POSTS'					=> 'Сообщения без автора',
	'NO_USER_POSTS_EXPLAIN'			=> 'Этот инструмент позволяет удалить сообщения несуществующих авторов (это может произойти в случае, если пользователи были удалены вручную непосредственно из базы данных, а не штатными средствами phpBB).',
	'AUTHOR_POSTS_REASSIGNED'		=> 'Авторы назначены для %d сообщений.',
	'NO_NO_USER_POSTS'				=> 'Сообщений от несуществующих авторов не обнаружено',
	'NO_AUTHOR_SELECTED'			=> 'Ни одного автора не назначено.',
	'POSTS_REASSIGNED_TO_GUEST'		=> 'Для %d сообщений автором назначен <b>Гость</b>',
	'REASSIGN_ANONYMOUS'			=> 'Назначить автором Гостя для выбранных',
));
