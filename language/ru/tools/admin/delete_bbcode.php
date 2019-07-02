<?php
/**
 *
 * @package Support Toolkit - Prune Styles Russian language Sheer
 * @copyright (c) 2019 phpBBGuru Sheer
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
	'DELETE_BBCODE'						=> 'Удаление bb-кодов',
	'DELETE_BBCODE_PROGRESS'			=> 'Обработано %1$d из %2$d ...',
	'DELETE_BBCODES'					=> 'Проводится удаление bb-кодов',
	'DELETE_BBCODE_COMPLETE'			=> 'Удаление bb-кодов завершено.',
	'IDS_EMPTY'							=> 'Вы не выбрали ни одного режима очистки bb-кодов. Если вы не знаете, какой режим выбрать, установите флажек <strong>Очистка BBCode везде</strong>.',
	'DELETE_BBCODE_POST_IDS'			=> 'Провести удаление bb-кодов только среди перечисленных сообщений',
	'DELETE_BBCODE_POST_IDS_EXPLAIN'	=> 'Укажите ID сообщения через запятую (например: 1,2,3,5,8,13).',
	'DELETE_BBCODE_FORUMS'				=> 'Провести удаление bb-кодов только в выбранных форумах',
	'DELETE_BBCODE_FORUMS_EXPLAIN'		=> 'Для выбора нескольких нескольких или всех форумов используйте соответствующую для вашего компьютера и браузера комбинацию мыши и клавиатуры.',
	'DELETE_BBCODE_SELECT'				=> 'Выберите bb-код, который хотите удалить',
	'DELETE_BBCODE_ALL'					=> 'Очистка BBCode везде',
	'DELETE_BBCODE_ALL_EXPLAIN'			=> 'Если отмечено, удаление BBCode будет произведено везде. Эта опция будет проигнорирована, если выше выбраны определенные сообщения или форумы. Это действие может занять значительное время. Кроме того, учтите, этот инструмент потенциально может повредить базу данных без возможности восстановления. Поэтому, <strong>не забудьте сделать резервную копию базы данных перед тем как продолжить</strong>.',



));
