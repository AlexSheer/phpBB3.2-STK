<?php
/**
*
* @package Support Toolkit - Merge Users Russian language Sheer
* @version $Id$
* @author Chris Smith <toonarmy@phpbb.com> (http://www.cs278.org/)
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
	'MERGE_USERS'							=> 'Объединение пользователей',
	'MERGE_USERS_EXPLAIN'					=> 'Инструмент объединит права доступа и все темы с сообщениями с одной пользовательской учётной записи в другую (установки исходного пользователя и его членство в группах - остаются). Переносятся (добавляются) права доступа, вложения, блокировки, закладки, черновики, записи о просмотрах форумов/тем, история посещений, голосование, сообщения, личные сообщения, жалобы, темы, предупреждения, записи о друзьях и недругах.',

	'MERGE_USERS_BOTH_FOUNDERS'				=> 'Вы не можете объединить основателя с неоснователем.',
	'MERGE_USERS_BOTH_IGNORE'				=> 'Вы не можете объединить бота с пользователем.',

	'MERGE_USERS_MERGED'					=> 'Пользователи успешно объединены.',

	'MERGE_USERS_REMOVE_SOURCE'				=> 'Удалить исходного пользователя',
	'MERGE_USERS_REMOVE_SOURCE_EXPLAIN'		=> 'Если отмечено, инструмент удалит исходного пользователя с конференции.',

	'MERGE_USERS_SAME_USERS'				=> 'Исходный и целевой пользователь должны быть разными.',

	'MERGE_USERS_USER_SOURCE_NAME'			=> 'Имя исходного пользователя (уничтожаемого)',
	'MERGE_USERS_USER_SOURCE_ID'			=> 'ID исходного пользователя (уничтожаемого)',
	'MERGE_USERS_USER_SOURCE_NAME_EXPLAIN'	=> 'Сообщения, личные сообщения, права доступа, предупреждения полностью перемещаются от данного пользователя к целевому пользователю, членство в группах и пользовательские установки копируются и слаживаются.',

	'MERGE_USERS_USER_TARGET_NAME'			=> 'Имя целевого пользователя (оставляемого)',
	'MERGE_USERS_USER_TARGET_ID'			=> 'ID целевого пользователя (оставляемого)',

	'NO_SOURCE_USER'						=> 'Исходный (уничтожаемый) пользователь не существует',
	'NO_TARGET_USER'						=> 'Целевой (оставляемый) пользователь не существует',

	'BOTH_SOURCE_USER'						=> 'Достаточно заполнить любое одно поле об исходном пользователе (уничтожаемом).',
	'BOTH_TARGET_USER'						=> 'Достаточно заполнить любое одно поле о целевом пользователе (оставляемом).',
));
