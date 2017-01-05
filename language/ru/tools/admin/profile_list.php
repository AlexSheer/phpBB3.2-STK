<?php
/**
*
* @package Support Toolkit - Profile List Russian language Sheer
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
	'ALL'						=> 'Все поля',
	'CLICK_TO_DELETE'			=> 'Выделенных пользователей можно удалить одним нажатием. Внимание! После удаления восстановление пользователей невозможно!',
	'FILTER'					=> 'Фильтр',
	'LIMIT'						=> 'Лимит отображения',
	'ONLY_NON_EMPTY'			=> 'Только с заполненными полями',
	'ORDER_BY'					=> 'Поле сортировки',
	'PROFILE_LIST'				=> 'Проверка и редактирование профилей пользователей',
	'PROFILE_LIST_EXPLAIN'		=> 'Инструмент отображает информацию из профиля пользователей согласно выбранных вариантов отображения. Этот инструмент может использоваться для определения спам-регистраций и массового удаления пользователей.',
	'USERS_DELETE'				=> 'Удалить отмеченных пользователей',
	'USERS_DELETE_CONFIRM'		=> 'Вы уверены, что желаете удалить отмеченных пользователей? Все сообщения выбранных пользователей будут также удалены!',
	'USERS_DELETE_SUCCESSFULL'	=> 'Все отмеченные пользователи успешно удалены.',
));
