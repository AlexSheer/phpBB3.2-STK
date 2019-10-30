<?php
/**
 *
 * @package Support Toolkit - Set prosilver as default style French language
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
	'SET_PROSILVER'						=> 'Définir « prosilver » par défaut',
	'SET_PROSILVER_CONFIRM'				=> 'Permet de définir le style « prosilver » par défaut pour tous les utilisateurs du forum.',
	'SET_PROSILVER_ALLREADY_ASSIGNED'	=> 'Le style « prosilver » est déjà le style par défaut du forum. Aucune action n’est nécessaire.',
	'SET_PROSILVER_ACTIVATED'			=> 'Le style « prosilver » a été activé avec succès !',
	'SET_PROSILVER_RESET'				=> 'Le style « prosilver » a été féfini comme le style par défaut pour tous les utilisateurs du forum.',
	'SET_PROSILVER_DOES_NOT_EXIST'		=> 'Le style « prosilver » n’existe pas. Merci d’envoyer une copie des fichiers depuis l’archive originale disponible sur : <a href="https://www.phpbb.com/downloads/">phpBB.com</a> (Archive originale de phpBB 3.2.1) ou <a href="http://www.phpbb-fr.com/telechargements/">phpBB-fr.com</a> (Archive originale française de phpBB 3.2.1).',
));
