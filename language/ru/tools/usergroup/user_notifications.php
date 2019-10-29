<?php
/**
*
* @package Support Toolkit - User Notifycations Russian language Sheer
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
	'ALL'							=> 'Для всех пользователей',
	'DEFAULT_NOTIFY_EXPLAIN'		=> 'Если выбрано &laquo;Нет&raquo;, то будет также будет удалена информация о подписанных форумах и темах.',
	'DELETE_NOTIFICATIONS'			=> 'Удалить уведомления',
	'DELETE_NOTIFICATIONS_EXPLAIN'	=> 'При удалении или отключении уведомлений все уведомления пользователей для выбранных типов будут удалены.',
	'NOTIFICATION_GROUP_EXT'		=> 'Уведомления, установленные расширениями',
	'SELECT_EXPLAIN'				=> 'Выберите период неактивности пользователя. Если будет выбрано &laquo;Для всех&raquo;, действие будет применено ко всем пользователям.',
	'USER_NOTIFICATIONS'			=> 'Настройки уведомлений',
	'USER_NOTIFICATIONS_EXPLAIN'	=> 'Здесь вы можете изменить настройки уведомлений по умолчанию для всех или неактивных за выбранный период времени пользователей. Действие по установке или отключению уведомления не будет применено, если пользователь не настроил их в своем личном разделе. Если настройки будут удалены, то пользователю будут приходить форумные уведомления, установленные в phpBB по умолчанию, никакие уведомления на почту придить не будут. Это будет действовать до тех пор, пока он не изменит их в своем Личном разделе.',
	'USER_NORIFY_OK'				=> 'Настройки уведомлений были успешно изменены.',
));
