<?php
/**
 *
 * @package Support Toolkit - User Notifications French language
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2009 phpBB Group
 * @license GNU General Public License, version 2 (GPL-2.0-only)
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
	'ALL'							=> 'Tout le monde',
	'DEFAULT_NOTIFY_EXPLAIN'		=> 'Permet, si définie sur « Non », de supprimer aussi les informations sur les forums et les sujets surveillés.',
	'DELETE_NOTIFICATIONS'			=> 'Supprimer les notifications',
	'DELETE_NOTIFICATIONS_EXPLAIN'	=> 'Permet de sélectionner les types de notifications à supprimer si celles-ci sont définies comme à supprimer ou à désactiver.',
	'NOTIFICATION_GROUP_EXT'		=> 'Notifications ajoutées par les extensions',
	'SELECT_EXPLAIN'				=> 'Sélectionner une période d’inactivité des membres. Si l’option « Tout le monde » est sélectionnée, tous les membres du forum seront concernés.',
	'USER_NOTIFICATIONS'			=> 'Préférences des notifications',
	'USER_NOTIFICATIONS_EXPLAIN'	=> 'Permet de modifier les paramètres par défaut des notifications pour tous les membres ou ceux ayant été inactifs suivant la période définie. L’action de re-configurer ou désactiver les notifications ne sera pas appliquée si le membre n’a pas configuré les notifications depuis son « Panneau de l’utilisateur ». Si les paramètres sont supprimés, le membre continuera de recevoir les notifications par défaut du forum, mais aucune notifications ne sera envoyée par e-mail. Le membre devra définir ce comportement depuis son « Panneau de l’utilisateur ». Aussi, cet outil ne supprime pas les notifications non lues des membres.',
	'USER_NORIFY_OK'				=> 'Les paramètres ont été sauvegardés avec succès !',
));
