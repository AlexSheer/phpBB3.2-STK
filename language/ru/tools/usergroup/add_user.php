<?php
/**
*
* @package Support Toolkit - Add User Russian language Sheer
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
	'ADD_USER'				=> 'Добавление новых пользователей',
	'ADD_USER_GROUP'		=> 'Добавить пользователя в группу (группы)',

	'DEFAULT_GROUP'			=> 'Группа по умолчанию',
	'DEFAULT_GROUP_EXPLAIN'	=> 'Группа по умолчанию для данного пользователя.',

	'GROUP_LEADER'			=> 'Лидер группы (групп)',
	'GROUP_LEADER_EXPLAIN'	=> 'Сделать этого пользователя лидером выбранной группы (групп).',

	'USER_ADDED'			=> 'Пользователь успешно добавлен в группу (группы)!',
	'USER_GROUPS'			=> 'Группа (группы) пользователя',
	'USER_GROUPS_EXPLAIN'	=> 'Добавить данного пользователя в состав выбранной группы (групп).',
	'EMAIL_ADDRESS'			=> 'Адрес email',
	'LANGUAGE'				=> 'Язык',
	'TIMEZONE'				=> 'Часовой пояс',
	'TOO_SHORT_USERNAME'		=> 'Имя пользователя слишком короткое.',
	'TOO_SHORT_NEW_PASSWORD'	=> 'Введённый пароль слишком короткий.',
	'TOO_SHORT_PASSWORD_CONFIRM'=> 'Подтверждение пароля слишком короткое.',
	'TOO_SHORT_EMAIL'			=> 'Адрес email слишком короткий.',
	'EMAIL_INVALID_EMAIL'		=> 'Введённый адрес email неверен.',
	'NEW_PASSWORD_ERROR'		=> 'Введённые вами пароли не совпадают.',
	'DOMAIN_NO_MX_RECORD'	=> 'Введённый домен email не имеет корректной почтовой записи в DNS (MX record).',
	'USERNAME_TAKEN'		=> 'Извините, пользователь с таким именем уже существует',
));
