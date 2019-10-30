<?php
/**
 *
 * @package Support Toolkit - Add User French language
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
	'ADD_USER'				=> 'Ajouter un utilisateur',
	'ADD_USER_GROUP'		=> 'Ajouter un utilisateur aux groupes',

	'DEFAULT_GROUP'			=> 'Groupe par défaut',
	'DEFAULT_GROUP_EXPLAIN'	=> 'Le groupe par défaut de cet utilisateur.',

	'GROUP_LEADER'			=> 'Responsable du groupe',
	'GROUP_LEADER_EXPLAIN'	=> 'Faire de cet utilisateur le responsable des groupes sélectionnés.',

	'USER_ADDED'			=> 'L’utilisateur a été créé.',
	'USER_GROUPS'			=> 'Groupes d’utilisateurs',
	'USER_GROUPS_EXPLAIN'	=> 'Faire de cet utilisateur un membre des groupes sélectionnés.',
	'EMAIL_ADDRESS'			=> 'Adresse e-mail',
	'LANGUAGE'				=> 'Langue',
	'TIMEZONE'					=> 'Fuseau horaire',
	'TOO_SHORT_USERNAME'		=> 'Le nom d’utilisateur saisi est trop court.',
	'TOO_SHORT_NEW_PASSWORD'	=> 'Le mot de passe saisi est trop court.',
	'TOO_SHORT_PASSWORD_CONFIRM'=> 'La confirmation du mot de passe saisi est trop courte.',
	'TOO_SHORT_EMAIL'			=> 'L’adresse e-mail saisie est trop courte.',
	'EMAIL_INVALID_EMAIL'		=> 'L’adresse e-mail saisie est incorrecte.',
	'NEW_PASSWORD_ERROR'		=> 'Les mots de passe saisis ne correspondent pas.',
	'DOMAIN_NO_MX_RECORD'	=> 'Le domaine de messagerie saisi n’a pas d’enregistrement de messagerie valide dans les DNS (enregistrement MX).',
	'USERNAME_TAKEN'		=> 'Le nom d’utilisateur saisit est déjà utilisé, merci de saisir un autre nom.',
));
