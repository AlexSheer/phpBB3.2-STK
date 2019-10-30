<?php
/**
 *
 * @package Support Toolkit - Reassign Thumbnails French language
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
	'REASSIGN_THUMBNAILS'			=> 'Reconstruction des miniatures',
	'REASSIGN_THUMBNAILS_CONFIRM'	=> 'Lorsque l’option suivante « Créer une miniature » est désactivée et que des fichiers joints existent, cet outil permet de créer des miniatures associées aux fichiers joints existants.<br />Poursuivre ?',
	'REASSIGN_THUMBNAILS_PROGRESS'	=> 'Création de miniatures en cours… merci de ne pas interrompre l’opération !',
	'REASSIGN_THUMBNAILS_FINISHED'	=> 'Création de miniatures terminée.',
	'NO_THUMBNAILS_TO_REBUILD'		=> 'Aucun fichier nécessite des miniatures.',
	'NEED_TO_PROCESS' 				=> 'Fichiers joints sans miniatures : ',
	'THUMB'							=> '<strong>miniature</strong>',
	'REBUILT'						=> 'Créer des miniatures',
	'NO_NEED_REBUILT'				=> '<strong style="color: #aaa;">Aucun besoin de miniatures</strong> for ',
	'SOURCE_UNAVAILABLE'			=> 'Fichier non trouvé : ',
	'NO_EXTENSIONS'					=> 'Il n’y a aucune extension de fichier pour le groupe d’extensions « <strong>Images</ strong> ».',
	'NO_EXTENSIONS_GROUP'			=> 'Le groupe d’extensions « <strong>Images</ strong> » n’existe pas.',
	'IMAGES'						=> 'Images',
));
