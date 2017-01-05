<?php
/**
*
* @package Support Toolkit - Restore Delted Users Russian language Sheer
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
	'DAMAGED_POSTS'								=> 'Поврежденнные сообщения',
	'DAMAGED_POSTS_EXPLAIN'						=> 'Следующие идентификаторы сообщений относятся к несуществующим пользователям. Посетите <a href="http://www.phpbbguru.net/community/forum47.html">форум поддержки</a> для получения помощи в решении этой проблемы.',

	'NO_DELETED_USERS'							=> 'Нет удалённых пользователей, которых можно было бы восстановить',
	'NO_USER_SELECTED'							=> 'Пользователи не выбраны!',

	'RESTORE_DELETED_USERS'						=> 'Восстановление (создание) удалённых пользователей',
	'RESTORE_DELETED_USERS_CONFLICT'			=> 'Восстановление (создание) удалённых пользователей : Конфликт',
	'RESTORE_DELETED_USERS_CONFLICT_EXPLAIN'	=> 'Этот инструмент позволяет вам восстановить (создать) удалённых пользователей, если оставлены их сообщения, как "гостевые".<br />Данным пользователям будут назначены случайные пароли, которые вы должны изменить вручную после окончания работы инструмента. Данный инструмент не предлагает список сгенерированных паролей для каждого пользователя!<br /><br />Во время последнего исполнения инструмент обнаружил, что некоторые имена уже используются на конференции. Пожалуйста предложите новые имена для пользователей.',
	'RESTORE_DELETED_USERS_EXPLAIN'				=> 'Этот инструмент позволяет вам восстановить (создать) удалённых пользователей, если оставлены их сообщения, как "гостевые".<br />Внимание! Выведенный список имен не является списком зарегистрированных на форуме пользователей! Этот список создан из имен, введенных в графе "Автор сообщения" гостями или в формах личных сообщений, если на конференции разрешено отправлять личные сообщения (заменяя свои настоящие имена на любые, не соответствующие действительным).',

	'SELECT_USERS'								=> 'Выбрать имена удаленных когда-то пользователей для восстановления (создания заново) новых пользователей под выбранными именами',

	'USER_RESTORED_SUCCESSFULLY'				=> 'Пользователь восстановлен (создан)',
	'USERS_RESTORED_SUCCESSFULLY'				=> 'Выбранные пользователи восстановлены (созданы)',
));
