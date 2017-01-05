<?php
/**
 *
 * @package Support Toolkit - Flash checker Russian language Sheer
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
	'FLASH_CHECKER'				=> 'Проверка скриптов на flash уязвимость',
	'FLASH_CHECKER_CONFIRM'		=> 'В phpBB 3.0.7-pl1 была обнаружена XSS-уязвимость во встроенном flash BBCode. Эта проблема безопасности была решена в phpBB 3.0.8. Данный инструмент проверяет все сообщения, Личные сообщения и подписи с учётом уязвимости BBCode. Как только уязвимость будет обнаружена, будет проведен быстрый репарсинг для сохранения безопасности вашей конференции. Прочтите <a href="http://www.phpbb.com/community/viewtopic.php?f=14&t=2111068">объявление о релизе phpBB 3.0.9</a> для более подробной информации об этой проблеме.',
	'FLASH_CHECKER_FOUND'		=> 'Контролёр flash обнаружил потенциально опасносные flash BBcode на вашей конференции. Нажмите <a href="%s"><b>здесь</b></a> для репарсинга сообщений и личных сообщений, содержащих flash BBCode.',
	'FLASH_CHECKER_NO_FOUND'	=> 'Потенциально опасных flash BBcode не обнаружено.',
	'FLASH_CHECKER_POST'		=> 'Если при повторной проверке обнаружилось, что проблема не устранена, перейдите по ссылке <a href="%s"><b>здесь</b></a> и отредактируйте сообщение.',
));
