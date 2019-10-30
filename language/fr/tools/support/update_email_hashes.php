<?php
/**
 *
 * @package Support Toolkit - Update Email Hashes French language
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
	'UPDATE_EMAIL_HASHES'				=> 'Mettre à jour les hachages des e-mails',
	'UPDATE_EMAIL_HASHES_CONFIRM'		=> 'Dans les installations de phpBB antérieures à phpBB 3.0.7, passer d’un système d’exploitation 32 bits à un système d’exploitation 64 bits peut provoquer un dysfonctionnement dans le hachage des e-mails. <em>(<a href="https://tracker.phpbb.com/browse/PHPBB3-9072">Consulter le rapport de bug lié à ce problème</a>)</em>.<br />Cet outil permet de mettre à jour les hachages dans la base de données afin qu’ils fonctionnent correctement.',
	'UPDATE_EMAIL_HASHES_COMPLETE'		=> 'Tous les hachages des e-mails ont été mis à jour.',
	'UPDATE_EMAIL_HASHES_NOT_COMPLETE'	=> 'Mise à jour des hachages des e-mails en cours.',
));
