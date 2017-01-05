<?php
/**
*
* @package Support Toolkit - User Options Russian language Sheer
* @version $Id$
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @
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
	'USER_OPTIONS'			=> 'Пользовательские настройки',
	'USER_OPTIONS_EXPLAIN'	=> 'Здесь вы можете изменить пользовательские настройки установленные по умолчанию для всех или выбранных групп пользователей.<br />Более подробную информацию можно получить <a href="http://www.phpbbguru.net/kb/administration/changing-user-defaults/" target="_blank"><b>здесь</b></a>.',
	'NOTHING'				=> 'Не изменять',
	'USER_OPTIONS_OK'		=> 'Пользовательские настройки были успешно изменены.',

	'viewimg'				=> 'Показывать изображения в сообщениях',
	'viewflash'				=> 'Показывать Flash-анимацию',
	'viewsmilies'			=> 'Заменять смайлики изображениями',
	'viewsigs'				=> 'Показывать подписи в сообщениях',
	'viewavatars'			=> 'Показывать аватары в сообщениях',
	'viewcensors'			=> 'Разрешить автоцензор',
	'attachsig'				=> 'Всегда присоединять подпись',
	'bbcode'				=> 'BBCode всегда включён',
	'smilies'				=> 'Смайлики всегда включены',
	'sig_bbcode'			=> 'BBCode включён в подписи',
	'sig_smilies'			=> 'Заменять смайлики изображениями в подписи',
	'sig_links'				=> 'Преобразовывать адреса URL в ссылки в подписи',

	'ALL_GROUPS'			=> 'Все группы',
));
