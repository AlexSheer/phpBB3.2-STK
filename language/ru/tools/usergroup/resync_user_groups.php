<?php
/**
 *
 * @package Support Toolkit - Resynchronise Registered users groups Russian language Sheer
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
	'RESYNC_USER_GROUPS'			=> 'Проверка прав стандартных пользовательских групп',
	'RESYNC_USER_GROUPS_EXPLAIN'	=> 'Этот инструмент предназначен для проверки всех пользователей на предмет принадлежности их к правильным группам (по умолчанию) (Зарегистрированные пользователи, COPPA пользователи и "Новые пользователи")',
	'RESYNC_USER_GROUPS_NO_RUN'		=> 'Все группы в правильных настройках!',
	'RESYNC_USER_GROUPS_SETTINGS'	=> 'Опции проверки (выбирать по одной опции!)',
	'RUN_BOTH_FINISHED'				=> 'Все группы пользователей были успешно проверены!',
	'RUN_RNR'						=> 'Проверка группы Новые пользователи',
	'RUN_RNR_EXPLAIN'				=> 'Эта проверка приведет к возвращению в группу Зарегистрированные пользователи всех пользователей, которые соответствуют критериям этой группы.',
	'RUN_RNR_FINISHED'				=> 'Пользователи группы Зарегистрированные пользователи были успешно проверены!',
	'RUN_RNR_NOT_FINISHED'			=> 'Идет проверка пользователей группы Зарегистрированные пользователи. Не прерывать!',
	'RUN_RR'						=> 'Проверка группы Зарегистрированные пользователи',
	'RUN_RR_EXPLAIN'				=> 'Обнаружено что не все ваши пользователи относятся к группе Зарегистрированные пользователи. Внести их в данную группу?',
	'RUN_RR_FINISHED'				=> 'Пользователи были успешно проверены на принадлежность к стандартным группам!',

	'SELECT_RUN_GROUP'				 => 'Выделите необходимые группы для проверки.',
));
