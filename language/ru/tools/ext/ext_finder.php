<?php
/**
*
* @package Support Toolkit - Ext Finder Russian language Sheer
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
	'EXT_TABLE_FINDER'			=> 'Таблицы',
	'EXT_TABLE_FINDER_EXPLAIN'	=> 'Здесь вы можете получить информацию о расширении, которым используется данная таблица:',
	'TABLE'						=> 'Таблица',

	'EXT_COLUMN_FINDER'			=> 'Поля таблиц',
	'EXT_COLUMN_FINDER_EXPLAIN'	=> 'Здесь вы можете получить информацию о расширении, которым используется данное поле таблицы:',
	'COLUMN'					=> 'Поле',

	'EXT_CONFIG_FINDER'			=> 'Параметры конфигурации',
	'EXT_CONFIG_FINDER_EXPLAIN'	=> 'Здесь вы можете получить информацию о расширении, которым используется данный параметр конфигурации:',
	'CONFIG'					=> 'Параметр',

	'EXT_MODULE_FINDER'			=> 'Модули',
	'EXT_MODULE_FINDER_EXPLAIN'	=> 'Здесь вы можете получить информацию о расширении, которым используется данный модуль:',
	'MODULE'					=> 'Модуль',

	'EXT_PERM_FINDER'			=> 'Права доступа',
	'EXT_PERM_FINDER_EXPLAIN'	=> 'Здесь вы можете получить информацию о расширении, которым используется данное право доступа:',
	'PERMISSION'				=> 'Право доступа',

	'PATH'				=> 'ПУТЬ, ОТНОСИТЕЛЬНО ПАПКИ ./ext',
	'INFO'				=> 'ИНФОРМАЦИЯ (название/версия  - описание)',
	'NOT_IN_EXT'		=> '<em>Элемент не является частью какого-либо расширения, назначение неизвестно</em>',

	'EXTRA_EXPLAIN'		=> 'статус расширения, его название, версию и краткое описание. Активные расширения <b style="color: #282">выделены зеленым цветом</b>.',
));
