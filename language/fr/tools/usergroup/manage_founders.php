<?php
/**
 *
 * @package Support Toolkit - Manage Founders French language
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
	'BOTH_FIELDS_FILLED'		=> 'Le champ « Nom d’utilisateur » et le champ « ID » d’utilisateur ne peuvent pas être remplis tous les deux.',

	'DEMOTE_FAILED'				=> 'Impossible de supprimer le statut de fondateur de tous les utilisateurs !',
	'DEMOTE_FOUNDERS'			=> 'Rétrograder les fondateurs',
	'DEMOTE_SUCCESSFULL'		=> 'Le statut de fondateur a été supprimé concernant %d utilisateur(s).',

	'FOUNDERS'					=> 'Utilisateurs ayant le statut de fondateur',

	'MAKE_FOUNDER'				=> 'Promouvoir un utilisateur en fondateur du forum',
	'MAKE_FOUNDER_CONFIRM'		=> 'Confirmer la promotion <a href="%1$s">%2$s</a> en fondateur du forum. Cela permettra, entre autres, à <a href="%1$s">%2$s</a> de pouvoir supprimer le compte.',
	'MAKE_FOUNDER_FAILED'		=> 'Impossible de promouvoir cet utilisateur en fondateur',
	'MAKE_FOUNDER_SUCCESS'		=> '<a href="%1$s">%2$s</a> a été promu en fondateur du forum.',
	'MANAGE_FOUNDERS'			=> 'Gérer les fondateurs du forum',

	'NO_FOUNDERS'				=> 'Aucun fondateur n’a été trouvé',

	'PROMOTE_FOUNDER'			=> 'Promouvoir en fondateur',

	'USER_NAME_TO_FOUNDER'			=> 'Nom d’utilisateur à promouvoir en fondateur',
	'USER_NAME_TO_FOUNDER_EXPLAIN'	=> 'Saisir le nom d’utilisateur à promouvoir en fondateur.',
	'USER_ID_TO_FOUNDER'			=> 'ID de l’utilisateur à promouvoir en fondateur',
	'USER_ID_TO_FOUNDER_EXPLAIN'	=> 'Saisir l’ID de l’utilisateur à promouvoir en fondateur.',
));
