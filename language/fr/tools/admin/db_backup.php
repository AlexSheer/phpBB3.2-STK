<?php
/**
 *
 * @package Support Toolkit - Database Backup French language
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
	'DB_BACKUP'					=> 'Sauvegarder la base de données',
	'DB_BACKUP_EXPLAIN'			=> 'Sur cette page il est possible de sauvegarder toutes les données de son forum phpBB. Il est possible de stocker l’archive créée dans le répertoire <samp>store/</samp>, la télécharger ou l’afficher à l’écran. Selon la configuration de son serveur il sera possible de compresser l’archive dans différents formats.',
	'DB_BACKUP_EXPLAIN_DUMPER'	=> 'La sauvegarde est compatible avec l’outil <a href ="http://www.mysqldumper.net/" target="_blank" /><strong>MySQLDumper</strong></a>, qui prend en charge la restauration des tables de la base de données.',

	'SELECT_TABLE'		=> 'Tables',
	'MARK_ALL'			=> 'Tout sélectionner',
	'EXPAND'			=> 'Étendre',
	'COLLAPSE'			=> 'Réduire',
	'UNMARK_ALL'		=> 'Tout désélectionner',
	'GZIP'				=> 'Compression',
	'SAVE'				=> 'Sauvegarder sur le serveur',
	'DOWNLOAD'			=> 'Télécharger',
	'BACKUP_SUCCESS'	=> 'La sauvegarde a été créée avec succès.',
	'BACKUP_ACTION'		=> 'Action',
	'BACKUP_TYPE'		=> 'Type de sauvegarde',
	'FULL'				=> 'Complète',
	'STRUCTURE'			=> 'Seulement la structure',
	'DATA'				=> 'Seulement les données',
	'SCREEN'			=> 'Afficher à l’écran'
));
