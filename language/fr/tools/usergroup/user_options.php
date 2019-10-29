<?php
/**
 *
 * @package Support Toolkit - User Options French language
 * French translation by Galixte (http://www.galixte.com)
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
	'USER_OPTIONS'			=> 'Modifier les options des utilisateurs',
	'USER_OPTIONS_EXPLAIN'	=> 'Sur cette page il est possible de modifier les paramètres utilisateur par défaut pour tous ou certains groupes sélectionnés.<br />Des informations plus détaillées peuvent être obtenues <a href="https://www.phpbb.com/support/docs/en/3.0/kb/article/changing-user-options-defaults-and-values/" target="_blank"><b>ici</b></a>.',
	'NOTHING'				=> 'Ne pas modifier',
	'USER_OPTIONS_OK'		=> 'Les paramètres des utilisateurs ont été modifiés avec succès.',

	'viewimg'				=> 'Afficher les images dans les messages',
	'viewflash'				=> 'Afficher les animations Flash',
	'viewsmilies'			=> 'Afficher les smileys comme les images',
	'viewsigs'				=> 'Afficher les signatures dans les messages',
	'viewavatars'			=> 'Afficher les avatars dans les messages',
	'viewcensors'			=> 'Activer la censure',
	'attachsig'				=> 'Activer par défaut la signature',
	'bbcode'				=> 'Autoriser par défaut les BBCodes',
	'smilies'				=> 'Activer par défaut les smileys',
	'sig_bbcode'			=> 'Autoriser les BBCodes dans les signatures',
	'sig_smilies'			=> 'Afficher les smileys comme les images dans les signatures',
	'sig_links'				=> 'Transformer les adresses URL en liens dans les signatures',

	'ALL_GROUPS'			=> 'Tous les groupes',
));
