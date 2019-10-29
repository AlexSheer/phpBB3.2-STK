<?php
/**
 *
 * @package Support Toolkit - Manager Extensions files French language
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
	'MANAGE_EXT'				=> 'Gestionnaire de fichiers des extensions',
	'EXT_NAME'					=> 'Nom de l’extension',
	'EXTENSIONS_FILES'			=> 'Fichiers de l’extension',
	'EXTENSIONS_FILES_EXPLAIN'	=> 'Sur cette page il est possible de voir, renommer supprimer ou créer de nouveaux fichiers ou répertoire pour son extension.',
	'EXPAND'					=> 'Étendre / réduire',
	'SAVE'						=> 'Sauvegarder',
	'SAVED'						=> 'Le fichier %s a été sauvegardé avec succès',
	'EDITED'					=> 'Le fichier %s a été modifié avec succès',
	'FAIL_CREATE_FILE'			=> 'Erreur de création du fichier %s',
	'FAIL_EXISTS'				=> 'Le fichier %s existe déjà',
	'FAIL_CREATE_DIR'			=> 'Erreur de création du répertoire %s',
	'ADD_NEW'					=> 'Ajouter un nouveau fichier',
	'PATH'						=> 'Chemin relatif vers le répertoire %s/',
	'PATH_EXPLAIN'				=> 'Si le répertoire n’existe pas, il sera créé',
	'FILE'						=> 'Nom du fichier',
	'CONTENT'					=> 'Contenu du code',
	'EXT_PATH'					=> 'Chemin relatif vers le répertoire ' . PHPBB_ROOT_PATH . 'ext/',
	'DELETE'					=> 'Supprimer',
	'RENAME'					=> 'Renommer',
	'DELETE_OK'					=> 'Le fichier %s a été supprimé avec succès',
	'DELETE_FAIL'				=> 'Erreur de suppression du fichier %s',
	'DELETE_FOLDER_OK'			=> 'Le répertoire %s a été supprimé avec succès',
	'DELETE_FOLDER_FAIL'		=> 'Erreur de suppression du répertoire %s',
	'NEW_NAME'					=> 'Nouveau nom',
	'RENAME_OK'					=> 'Le fichier %1s a été renommé en %2s',
	'RENAME_FAIL'				=> 'Erreur pour renommer le fichier %s',
	'RENAME_FOLDER_OK'			=> 'Le répertoire %1s a été renommé en %2s',
	'RENAME_FOLDER_FAIL'		=> 'Erreur pour renommer le répertoire %s',

	'ENABLED'					=> 'Activée',
	'DISABLED'					=> 'Désactivée',
	'NOT_INSTALLED'				=> 'Pas installée',
	'NO_EXTENSIONS_FILES'		=> '<strong>Des fichiers sont introuvables</strong>.<br />Probablement dû au fait que l’extension n’est pas installée, voire que des fichiers ou répertoires sont manquants.',
));
