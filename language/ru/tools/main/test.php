<?php
/**
*
* @package Support Toolkit - Test Russian language Sheer
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
	'TEST'				=> 'Общие сведения',
	'DATABASE_INFO'		=> 'Сервер базы данных',
	'DBMS'				=> 'Тип базы данных',
	'PHP_INFO'			=> 'Сведения о php',
	'PHP_VERSION'		=> 'Версия php',
	'STK_VERSION'		=> 'Версия Support Tookit',
	'MBSTRING_LOADED'	=> 'Функции для работы с многобайтными строками (расширение php <b>mbstring</b>) загружены',
	'MBSTRING_NOT_LOADED'				=> 'Функции для работы с многобайтными строками (расширение php <b>mbstring</b>) не загружены',
	'ERROR_MBSTRING_NOT_LOADED_EXPLAIN'	=> 'mbstring не входит в список расширений, устанавливаемых по умолчанию. Это значит, что изначально это расширение отключено. Для использования функций этого расширения необходимо явно включить модуль в настройке php. Обратитесь за справкой к <a href="http://php.net/manual/ru/mbstring.configuration.php">документации по php</a>',
));
