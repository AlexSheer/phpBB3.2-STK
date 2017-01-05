<?php
/**
 *
 * @package Support Toolkit - Prune Attachments Russian language Sheer
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
	'PRUNE_ATTACHMENTS'				=> 'Проверка файлов вложений',
	'PRUNE_ATTACHMENTS_EXPLAIN'		=> 'Данный инструмент проверяет существование на сервере лишних файлов вложений (<em>проверяются файлы из подпапок!</em>). Если будет обнаружено, что файл существует, он будет удален. Продолжить?',
	'PRUNE_ATTACHMENTS_FINISHED'	=> 'Лишних файлов вложений не обнаружено.',
	'PRUNE_ATTACHMENTS_PROGRESS'	=> 'Проводится проверка лишних файлов. Не прерывайте процесс!<br />Следующие файлы были удалены:',
	'PRUNE_ATTACHMENTS_FAIL'		=> '<br />Следующие файлы не удалось удалить:',
));
