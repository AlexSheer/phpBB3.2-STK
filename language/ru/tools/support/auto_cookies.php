<?php
/**
*
* @package Support Toolkit - Auto Cookies Russian language
* @version $Id$
* @copyright (c) 2016 Sheer
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
	'AUTO_COOKIES'				=> 'Изменение настроек Авто Cookies конференции',
	'AUTO_COOKIES_EXPLAIN'		=> 'Позволяет вам сменить установки Cookies конференции. Предлагаемый вариант скопирован из настроек администраторского раздела, скорей всего он корректен.',

	'COOKIE_SETTINGS_UPDATED'	=> 'Настройки Cookies успешно обновлены.',
	'COOKIE_DOMAIN'				=> 'Домен cookie',
	'COOKIE_NAME'				=> 'Имя cookie',
	'COOKIE_PATH'				=> 'Путь cookie',
	'COOKIE_SECURE'				=> 'Безопасные cookie [ https ]',
	'COOKIE_SECURE_EXPLAIN'		=> 'Если ваш сервер работает через SSL, то включите этот параметр. В противном случае оставьте отключённым. Включение этого параметра, если сервер работает не через SSL, приведёт к ошибкам при переходах по страницам конференции и при переадресации.',
));
