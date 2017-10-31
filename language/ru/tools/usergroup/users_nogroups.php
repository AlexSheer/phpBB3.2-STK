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
	'USERS_NOGROUPS'			=> 'Пользователи без групп',
	'USERS_NOGROUPS_EXPLAIN'	=> 'Это список пользователей, которые по каким-то причинам не принадлежат ни к одной из установленных на конференции групп.
								Вы можете отметить любого пользователя и назначить ему группу по умолчанию, а также другую группу или группы,
								в которые будет входить пользователь.',
	'LOST_GROUPS_USERS'			=> 'Пользователи, не принадлежащие ни к каким группам',
	'NO_USERS_FOUND'			=> 'Не найдено пользователей, не принадлежащих ни к каким группам',
	'NO_USERS_SELECTED'			=> 'Вы должны выбрать хотя бы одного пользователя.',
	'ASSIGHN_GROUPS_SUCCESS'	=> 'Выбранные пользователи были успешно добавлены в в группу (группы).',
));
