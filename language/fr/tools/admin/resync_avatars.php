<?php
/**
 *
 * @package Support Toolkit - Resync Avatars French language
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
	'RESYNC_AVATARS'			=> 'Resynchroniser les avatars',
	'RESYNC_AVATARS_CONFIRM'	=> 'Cet outil vérifiera si tous les avatars utilisés sur le forum existent actuellement sur le serveur. Lorsque des fichiers manquants sont décelés, l’avatar sera supprimé du profil des utilisateurs. Poursuivre ?',
	'RESYNC_AVATARS_FINISHED'	=> 'Les avatars ont été resynchronisés.',
	'RESYNC_AVATARS_NEXT_MODE'	=> 'Traitement des avatars de groupe. Merci de ne pas interrompre cette opération.',
	'RESYNC_AVATARS_PROGRESS'	=> 'Resynchronisation des avatars en cours. Merci de ne pas interrompre cette opération.',
));
