<?php
/**
 *
 * @package Support Toolkit - Fix Left/Right ID's French language
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
	'FIX_LEFT_RIGHT_IDS'			=> 'Réparer les ID de droite et de gauche',
	'FIX_LEFT_RIGHT_IDS_CONFIRM'	=> 'Confirmer la réparation des ID de droite et de gauche.<br /><br /><strong>Merci sauvegarder la base de données avant d’exécuter cet outil !</strong>',

	'LEFT_RIGHT_IDS_FIX_SUCCESS'	=> 'Les ID de droite et de gauche ont été réparés.',
	'LEFT_RIGHT_IDS_NO_CHANGE'		=> 'L’outil a terminé le balayage de toutes les ID de droite et de gauche et toutes les lignes sont déjà correctes. Aucune modification n’a donc été apportée.',
));
