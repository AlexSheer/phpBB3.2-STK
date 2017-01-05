<?php
/**
 *
 * @package Support Toolkit - Database Backup Russian language Sheer
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
	'DB_BACKUP'					=> 'Резервное копирование',
	'DB_BACKUP_EXPLAIN'			=> 'Здесь вы можете создать резервную копию таблиц базы данных конференции. Вы можете сохранить конечный архив на сервере в папке store/ , скачать его или вывести текст на дисплей. В зависимости от конфигурации сервера может быть доступно сжатие файла резервной копии в нескольких форматах.',
	'DB_BACKUP_EXPLAIN_DUMPER'	=> 'Полученный дамп резервной копии совместим с форматом утилиты <a href ="http://www.mysqldumper.net/" target="_blank" /><strong>MySQLDumper</strong></a>, которая поддерживает выборочное восстановление таблиц базы данных.<br />Более подробную информацию можно получить <a href="http://www.phpbbguru.net/community/topic33258.html" target="_blank" /><strong>здесь</strong></a>.',

	'SELECT_TABLE'		=> 'Таблицы',
	'MARK_ALL'			=> 'Выделить все',
	'EXPAND'			=> 'Разверуть',
	'COLLAPSE'			=> 'Свернуть',
	'UNMARK_ALL'		=> 'Снять выделение',
	'GZIP'				=> 'Сжатие',
	'SAVE'				=> 'Сохранить на сервере',
	'DOWNLOAD'			=> 'Скачать',
	'BACKUP_SUCCESS'	=> 'Резервное копирование успешно выполнено.',
	'BACKUP_ACTION'		=> 'Действие',
	'BACKUP_TYPE'		=> 'Тип копии',
	'FULL'				=> 'Полная',
	'STRUCTURE'			=> 'Только структура',
	'DATA'				=> 'Только данные',
	'SCREEN'			=> 'Показать на дисплее'
));
