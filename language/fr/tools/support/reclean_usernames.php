<?php
/**
 *
 * @package Support Toolkit - Reclean Usernames French language
 * French translation by phpBB-fr http://www.phpbb-fr.com & Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2017 phpBB Limited <https://www.phpbb.com>
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'RECLEAN_USERNAMES'					=> 'Re-nettoyer les noms des utilisateurs',
	'RECLEAN_USERNAMES_COMPLETE'		=> 'Tous les noms des utilisateurs ont été re-nettoyés.',
	'RECLEAN_USERNAMES_CONFIRM'			=> 'Confirmer le re-nettoyage de tous les noms des utilisateurs ?',
	'RECLEAN_USERNAMES_NOT_COMPLETE'	=> 'L’outil de re-nettoyage des noms des utilisateurs est en cours d’exécution… Merci de ne pas interrompre cette opération.',
	'USER_ALREADY_EXISTS'				=> 'Un utilisateur ayant le nom d’utilisateur <a href="%2$s" target="_blank" />%1$s</a> existe déjà.<br />Voici l’utilisateur ayant le mauvais nom d’utilisateur nettoyé : <a href="%4$s" target="_blank" />%3$s</a>',
));
