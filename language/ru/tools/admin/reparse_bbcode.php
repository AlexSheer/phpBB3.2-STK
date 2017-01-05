<?php
/**
*
* @package Support Toolkit - Reparse BBCode Russian language Sheer
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
// í ª ì î Ö
//

$lang = array_merge($lang, array(
	'REPARSE_ALL'					=> 'Репарсинг абсолютно всех BBCode',
	'REPARSE_ALL_EXPLAIN'			=> 'Если отмечено, будет произведён репарсинг BBCode на всей конференции; по умолчанию инструмент проверяет BBCode в сообщениях, личных сообщениях и подписях. Эта опция будет проигнорирована, если выше выбраны определенные сообщения, пользователи или форумы. Это действие может занять значительное время. Кроме того, учтите, этот инструмент потенциально может повредить базу данных без возможности восстановления. Поэтому, <strong>не забудьте сделать резервную копию базы данных перед тем как продолжить</strong>.',
	'REPARSE_BBCODE'				=> 'Репарсинг BBCode сообщений и ЛС',
	'REPARSE_BBCODE_COMPLETE'		=> 'Репарсинг BBCode проведён',
	'REPARSE_BBCODE_PROGRESS'		=> 'Обработано %1$d из %2$d ...',
	'REPARSE_BBCODE_SWITCH_MODE'	=> array(
		1	=> 'Закончен репарсинг сообщений, переход к репарсингу личных сообщений.',
		2	=> 'Закончен репарсинг личных сообщений, переход к репарсингу подписей.',
	),
	'REPARSE_BBCODE_MODE'			=> array(
		0	=> 'Проводится репарсинг сообщений.',
		1	=> 'Проводится репарсинг личных сообщений.',
		2	=> 'Проводится репарсинг подписей.',
	),
	'REPARSE_IDS_INVALID'			=> 'Указанные вами идентификаторы некорректны; пожалуйста, убедитесь, что идентификаторы (ID) перечислены как список, разделенный запятыми (например: 1,2,3,5,8,13).',
	'REPARSE_IDS_EMPTY'				=> 'Вы не выбрали ни одного режима репарсинга. Если вы не знаете, какой режим выбрать, установите флажек <strong>Репарсинг абсолютно всех BBCode</strong>.',
	'REPARSE_POST_IDS'				=> 'Провести репарсинг только перечисленных сообщений',
	'REPARSE_POST_IDS_EXPLAIN'		=> 'Провести репарсинг только перечисленных сообщений, Укажите ID сообщения через запятую (например: 1,2,3,5,8,13).',
	'REPARSE_PM_IDS'				=> 'Провести репарсинг Личных сообщений только перечисленных пользователей',
	'REPARSE_PM_IDS_EXPLAIN'		=> 'Провести репарсинг Личных сообщений только перечисленных пользователей. Укажите ID пользователей через запятую (например: 1,2,3,5,8,13).',
	'REPARSE_FORUMS'				=> 'Провести репарсинг сообщений только в выбранных форумах',
	'REPARSE_FORUMS_EXPLAIN'		=> 'Для выбора нескольких нескольких или всех форумов используйте соответствующую для вашего компьютера и браузера комбинацию мыши и клавиатуры.',
	'CREATE_BACKUP_TABLE'			=> 'Содать резервную копию',
	'CREATE_BACKUP_TABLE_EXPLAIN'	=> 'В базе данных будет создана таблица, из которой можно будет восстановить сообщения в случае неудачи или аварийного завершения работы инструмента.',
));
