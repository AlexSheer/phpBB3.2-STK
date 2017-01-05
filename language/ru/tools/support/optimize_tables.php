<?php
/**
*
* @package Support Toolkit - DB Optimizer Russian language Sheer
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
	'OPTIMIZE_TABLES'			=> 'Оптимизация таблиц БД',
	'OPTIMIZE_TABLES_EXPLAIN'	=> 'Поиск таблиц базы данных, нуждающихся в дефрагментации, и их оптимизация',
	'GO'						=> 'Оптимизировать',
	'FRAGMENTED'				=> 'Фрагментировано',
	'CREATE_TIME'				=> 'Создана',
	'UPDATE_TIME'				=> 'Последнее изменение',
	'CHECK_TIME'				=> 'Проверена',
	'NOT_FOUND' 				=> 'Таблиц, нуждающихся в оптимизации не обнаружено',
	'TABLE_NAME'				=> 'Таблица',
	'TABLE_SIZE'				=> 'Занято',
	'ALL'						=> 'Итого: ',
	'SUCESS'					=> 'Выбранные таблицы были успешно оптимизированы',
	'NOTHING'					=> 'Ничего не выбрано',
	'OPTIMIZER_MESSAGE'			=> '<b>Внимание!</b> Из-за большого размера таблиц и сильной фрагментации, процесс оптимизации может занять значительное время.<br />Пожалуйста, не покидайте эту страницу, пока не дождетесь результатов оптимизации.',
));
