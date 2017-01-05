<?php
/**
*
* @package Support Toolkit - phpbb Russian language Sheer
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

/**
* DO NOT CHANGE
*/
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
	'MANAGE_EXT'				=> 'Управление файлами расширений',
	'EXT_NAME'					=> 'Имя расширения',
	'EXTENSIONS_FILES'			=> 'Файлы расширений',
	'EXTENSIONS_FILES_EXPLAIN'	=> 'Здесь вы можете просмотреть, переименовать, удалить или создать новые файлы или папки в ваших расширениях.',
	'EXPAND'					=> 'Свернуть/Развернуть',
	'SAVE'						=> 'Сохранить',
	'SAVED'						=> 'Файл %s был успешно сохранен',
	'EDITED'					=> 'Файл %s был успешно изменен',
	'FAIL_CREATE_FILE'			=> 'Не удалось создать Файл %s',
	'FAIL_EXISTS'				=> 'Файл %s уже существует',
	'FAIL_CREATE_DIR'			=> 'Не удалось создать папку %s',
	'ADD_NEW'					=> 'Добавить новый файл',
	'PATH'						=> 'Путь, относительно папки %s/',
	'PATH_EXPLAIN'				=> 'Если папка не существует, она будет создана',
	'FILE'						=> 'Имя файла',
	'CONTENT'					=> 'Код',
	'EXT_PATH'					=> 'Путь относительно папки ' . PHPBB_ROOT_PATH . 'ext/',
	'DELETE'					=> 'Удалить',
	'RENAME'					=> 'Переименовать',
	'DELETE_OK'					=> 'Файл %s был успешно удален',
	'DELETE_FAIL'				=> 'Не удалось удалить файл %s',
	'DELETE_FOLDER_OK'			=> 'Папка %s была успешно удалена',
	'DELETE_FOLDER_FAIL'		=> 'Не удалось удалить папку %s',
	'NEW_NAME'					=> 'Новое имя',
	'RENAME_OK'					=> 'Файл %1s был успешно переименован в %2s',
	'RENAME_FAIL'				=> 'Не удалось переименовать файл %s',
	'RENAME_FOLDER_OK'			=> 'Папка %1s была успешно переименована в %2s',
	'RENAME_FOLDER_FAIL'		=> 'Не удалось переименовать папку %s',

	'ENABLED'					=> 'Активно',
	'DISABLED'					=> 'Отключено',
	'NOT_INSTALLED'				=> 'Не установлено',
	'NO_EXTENSIONS_FILES'		=> '<strong>Файлы расширений отсутствуют</strong>.<br />Возможно не установлено ни одного расширения, либо отсутствуют папки и файлы установленных расширений.',
));
