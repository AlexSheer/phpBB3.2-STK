<?php
/**
*
* @package Support Toolkit - Update email hashes Russian language Sheer
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
	'UPDATE_EMAIL_HASHES'				=> 'Обновление контрольных сумм email-адресов',
	'UPDATE_EMAIL_HASHES_CONFIRM'		=> 'В версиях phpBB более ранних, чем 3.0.7, переход от 32 разрядной операционной системы к 64 разрядной нарушает хеш email.<br /><em>(<a href="http://tracker.phpbb.com/browse/PHPBB3-9072" target="_blank">Смотри сообщение об этой ошибке</a>)</em><br />Этот инструмент позволяет обновить контрольные суммы email-адресов в базе данных для корректной работы конференции.',
	'UPDATE_EMAIL_HASHES_COMPLETE'		=> 'Все контрольные суммы email-адресов были успешно обновлены.',
	'UPDATE_EMAIL_HASHES_NOT_COMPLETE'	=> 'Проводится обновление хеша email.',
));
