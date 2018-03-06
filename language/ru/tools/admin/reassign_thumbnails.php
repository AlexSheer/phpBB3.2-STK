<?php
/**
 *
 * @package Support Toolkit - Reassign Thumbnails Russian language Sheer
 * @copyright (c) 2017 Sheer
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
	'REASSIGN_THUMBNAILS'			=> 'Пересоздание миниатюр файлов вложений',
	'REASSIGN_THUMBNAILS_CONFIRM'	=> 'В случае, если была отключена опция &laquo;Создавать миниатюры&raquo; и вложения были созданы, вы можете создать миниатюры для таких вложений.<br />Продолжить?',
	'REASSIGN_THUMBNAILS_PROGRESS'	=> 'Производится создание миниатюр. Не прерывайте процесс!',
	'REASSIGN_THUMBNAILS_FINISHED'	=> 'Пересоздание миниатюр завершено.',
	'NO_THUMBNAILS_TO_REBUILD'		=> 'Нет файлов для которых требуется создание миниатюр.',
	'NEED_TO_PROCESS' 				=> 'Найдено файлов без миниатюр: %d',
	'REBUILT'						=> '<strong>Создано для</strong> ',
	'NO_NEED_REBUILT'				=> '<strong style="color: #aaa;">Не требуется</strong> создание миниатюры для файла ',
	'THUMB'							=> '<strong>миниатюра</strong>',
	'SOURCE_UNAVAILABLE'			=> 'Файл не найден: ',
	'NO_EXTENSIONS'					=> 'Для группы расширений <strong>Изображения</strong> нет назначенных расширений файлов.',
	'NO_EXTENSIONS_GROUP'			=> 'Группа расширений <strong>Изображения</strong> не существует.',
	'IMAGES'						=> 'Изображения',
));
