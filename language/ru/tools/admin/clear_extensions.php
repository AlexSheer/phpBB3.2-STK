<?php
/**
*
* @package Support Toolkit - Clear Extensions Russian language
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
	'CLEAR_EXTENSIONS'				=> 'Проверка и управление расширениями',
	'CLEAR_EXTENSIONS_EXPLAIN'		=> 'Здесь вы можете управлять <b>установленными</b> расширениями.',
	'EXT_PATH'						=> 'Путь относительно папки ' . PHPBB_ROOT_PATH . 'ext/',
	'MISSING_PATH'					=> 'Отсутствующая папка',
	'S_ACTIVE'						=> ' (активно) ',
	'S_OFF'							=> ' (отключено) ',
	'EXT_NAME'						=> 'Имя расширения',
	'CLICK_TO_CLEAR'				=> 'Записи о выбранных установленных расширениях будут удалены из базы данных и расширения отключены, однако данные, относящиеся к этим расширениям, такие как таблицы или значения конфигурации, останутся. Для их удаления воспользуйтесь <b>ИНСТРУМЕНТЫ ПОДДЕРЖКИ</b> --> Проверка изменений в Базе Данных',
	'CLICK_TO_OFF'					=> 'Выбранные расширения будут отключены. При отключении расширения его файлы, данные и настройки сохраняются, но добавленная этим расширением функциональность удаляется.',
	'OFF_EXT'						=> 'Отключить',
	'CLEAR_EXT_SUCCESS'				=> 'Выбранные расширения успешно удалены.',
	'OFF_EXT_SUCCESS'				=> 'Выбранные расширения успешно отключены.',
	'NO_EXT_SELECTED'				=> 'Ничего не выбрано!',
	'EXT_DELETE'					=> 'Удалить расширения',
	'EXT_DELETE_CONFIRM'			=> 'Вы действительно желаете удалить эти расширения?',
	'EXT_OFF'						=> 'Отключить расширения',
	'EXT_OFF_CONFIRM'				=> 'Вы действительно желаете отключить эти расширения?',
	'EXT_MISSING_PATH'				=> 'Расширение «%s» не является совместимым.<br />',
	'NO_COMPOSER'					=> 'Запрашиваемый файл не найден: ' . PHPBB_ROOT_PATH . 'ext/%s/composer.json',
	'NO_EXTENSIONS_TITLE'			=> 'Расширения',
	'NO_EXTENSIONS_TEXT'			=> 'Не найдено ни одного установленного расширения',
));
