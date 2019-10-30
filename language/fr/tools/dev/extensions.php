<?php
/**
 *
 * @package Support Toolkit - Extensions French language
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
	'EXTENSIONS'			=> 'Développer des extensions',
	'EXTENSIONS_EXPLAIN'	=> 'Création des éléments de l’extension. Une fois les actions nécessaires réalisées la structure minimale de l’extension sera mise en place. Pour créer une extension à part entière il est nécessaire de modifier les fichiers générés et en ajouter de nouveaux au besoin.',
	'DEVELOPER'				=> 'Nom (surnom) du développeur',
	'DEVELOPER_EXPLAIN'		=> 'Il s’agit du nom (surnom) du développeur de l’extension, qui sera affiché dans le PCA, dans l’onglet <strong>&laquo;Personnaliser-->Gestionnaire d’extensions-->Détails&raquo;</strong> ainsi que d’autres paramètres facultatifs que l’on peut saisir ci-dessous.',
	'AUTHOR_EXPLAIN'		=> 'Nom du répertoire de l’auteur.<br />Dans le répertoire ./ext/ un dossier sera créé (si il n’existe pas déjà) portant le nom saisi pour ce paramètre. Toutes les extensions de l’auteur doivent être à situées dans ce répertoire. Les noms des dossiers n’acceptent pas les traits d’union, et les tirets du 8. Le nom du répertoire de l’auteur doit être composé d’au moins 3 caractères.',
	'EXT_EXPLAIN'			=> 'Nom du répertoire de l’extension.<br />Dans le répertoire ./ext/nomdelauteur/ un répertoire sera crée portant le nom saisi pour ce paramètre. Tous les fichiers et répertoires de l’extension doivent être à situés dans ce répertoire. Le nom du répertoire de l’extension doit être composé d’au moins 3 caractères.',
	'DISPLAY_NAME'			=> 'Nom de l’extension',
	'DESCRIPTION'			=> 'Description',
	'VERSION'				=> 'Version de l’extension',
	'DESCRIPTION_EXPLAIN'	=> 'Description courte de l’extension.',
	'ROLE'					=> 'Fonction du développeur',
	'ROLE_EXPLAIN'			=> 'Description courte de la contribution de l’auteur au développement de l’extension.',
	'HOMEPAGE'				=> 'Site Internet du développeur',

	'EMPTY_VENDOR'			=> 'Aucun nom spécifié pour le répertoire de l’auteur',
	'EMPTY_EXT_NAME'		=> 'Aucun nom spécifié pour le répertoire de l’extension',
	'EMPTY_AUTHOR'			=> 'Aucun nom (surnom) spécifié pour le développeur',
	'EMPTY_DISPLAY_NAME'	=> 'Aucun nom spécifié pour l’extension',
	'EMPTY_VERSION'			=> 'Aucune version spécifiée pour l’extension',
	'VENDOR_NAME_TOO_SHORT'	=> 'Le nom du répertoire de l’auteur doit être composé d’au moins 3 caractères.',
	'EXT_NAME_TOO_SHORT'	=> 'Le nom du répertoire de l’extension doit être composé d’au moins 3 caractères.',

	'ARE_REQUIRED'			=> '<hr>Les champs accompagnés d’un * sont nécessaires.',
	'SUCCESS'				=> 'Les éléments de l’extension ont été crées avec succès. Maintenant, il est possible de commencer le développement de l’extension.',
	'ALREADY_EXISTS'		=> 'Cette extension existe déjà !',
));
