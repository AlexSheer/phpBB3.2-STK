<?php
/**
*
* @package Support Toolkit - Anonymous group check Russian language Sheer
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
	'ANONYMOUS_CLEANED'					=> 'Данные профиля Гостя успешно обновлены.',
	'ANONYMOUS_CORRECT'					=> 'Учётная запись Гостя существует и все данные корректны!',
	'ANONYMOUS_CREATED'					=> 'Учётная запись Гостя успешно пересоздана.',
	'ANONYMOUS_CREATION_FAILED'			=> 'Невозможно пересоздать учётную запись гостя. Обратитесь за поддержкой на <a href="http://www.phpbbguru.net/community/forum47.html">официальный сайт поддержки phpBB3</a>',
	'ANONYMOUS_GROUPS_REMOVED'			=> 'Учётная запись Гостя успешно удалена из всех групп конференции.',
	'ANONYMOUS_MISSING'					=> 'Учётная запись Гостя повреждена.',
	'ANONYMOUS_MISSING_CONFIRM'			=> 'Учётная запись Гостя в вашей базе данных повреждена. Данный аккаунт используется для организации гостевого доступа на конференцию. Вы хотите создать её?',
	'ANONYMOUS_WRONG_DATA'				=> 'Данные профиля Гостя некорректны.',
	'ANONYMOUS_WRONG_DATA_CONFIRM'		=> 'Данные профиля Гостя некорректны. Вы хотите восстановить их значениями по умолчанию?',
	'ANONYMOUS_WRONG_GROUPS'			=> 'Учётная запись Гостя принадлежит к нескольким группам.',
	'ANONYMOUS_WRONG_GROUPS_CONFIRM'	=> 'Учётная запись Гостя принадлежит к нескольким группам. Вы хотите удалить Гостя из всех групп, кроме группы ГОСТИ?',

	'REDIRECT_NEXT_STEP'				=> 'Вы будете перенаправлены к следующему шагу.',

	'SANITISE_ANONYMOUS_USER'			=> 'Проверка прав учётной записи Гостя',
));
