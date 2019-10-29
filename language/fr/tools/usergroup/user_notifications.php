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
	'ALL'							=> 'Everyone',
	'DEFAULT_NOTIFY_EXPLAIN'		=> 'If &laquo;No&raquo; is selected, information about signed forums and topics will also be deleted.',
	'DELETE_NOTIFICATIONS'			=> 'Delete notifications',
	'DELETE_NOTIFICATIONS_EXPLAIN'	=> 'If you delete or turn off notifications, all user notifications for the selected types will be deleted.',
	'NOTIFICATION_GROUP_EXT'		=> 'Notifications wich add from extensions',
	'SELECT_EXPLAIN'				=> 'Select a period of user inactivity. If "Everyone" is selected, the action will be applied to all users.',
	'USER_NOTIFICATIONS'			=> 'Notification options',
	'USER_NOTIFICATIONS_EXPLAIN'	=> 'Here you can change the default notification settings for all or inactive users for a selected period of time. The action to set or disable the notification will not be applied if the user has not configured them in his User Control Panel. If the settings are deleted, the user will receive forum notifications installed in phpBB by default, no notifications will be sent to the mail. This will be valid until he changes them in his User Control Panel..',
	'USER_NORIFY_OK'				=> 'Settings have been successfully changed.',
));
