<?php
/**
 *
 * @package Support Toolkit - Extensions cleaner French language
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2009 phpBB Group
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
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'CLEAR_EXTENSIONS'			=> 'Verifier & gérer les extensions',
	'CLEAR_EXTENSIONS_EXPLAIN'	=> 'Depuis cette page il est possible de désactiver/activer ou supprimer les supprimer les extensions <strong>installées</strong>.',
	'EXT_PATH'					=> 'Chemin relatif au répertoire ' . PHPBB_ROOT_PATH . 'ext/',
	'MISSING_PATH'				=> 'Répertoire manquant ',
	'S_ACTIVE'					=> ' (activée) ',
	'S_OFF'						=> ' (désactivée) ',
	'EXT_NAME'					=> 'Nom de l’extension',
	'CLICK_TO_CLEAR'			=> 'Les données des extensions sélectionnées seront supprimées de la base de données et les extensions seront désactivées, cependant, les données relatives à ces extensions, telles que les tables et les données de configuration seront préservées.',
	'CLICK_TO_OFF'				=> 'Les extensions sélectionnées seront désactivées. Lorsque l’extension est désactivée ses données, ses fichiers, et ses paramètres sont préservés,<br />mais les fonctionnalités ajoutées par l’extension n’est plus disponible.',
	'OFF_EXT'					=> 'Désactiver',
	'CLEAR_EXT_SUCCESS'			=> 'Les extensions sélectionnées ont été supprimées avec succès !',
	'OFF_EXT_SUCCESS'			=> 'Les extensions sélectionnées ont été désactivées avec succès !',
	'ON_EXT_SUCCESS'			=> 'Les extensions sélectionnées ont été activées avec succès !',
	'NO_EXT_SELECTED'			=> 'Aucune extension n’a été sélectionnée !',
	'EXT_DELETE'				=> 'Extensions supprimées',
	'EXT_OFF'					=> 'Extensions désactivées',
	'EXT_MISSING_PATH'			=> 'L’extension « %s » est incorrecte.<br />',
	'NO_COMPOSER'				=> 'Le fichier demandé n’a pu être trouvé : ' . PHPBB_ROOT_PATH . 'ext/%s/composer.json',
	'NO_EXTENSIONS_TITLE'		=> 'Extensions',
	'NO_EXTENSIONS_TEXT'		=> 'Aucune extension n’a été trouvée',
	'OFF_EXT'					=> 'Désactiver',
	'ON_EXT'					=> 'Activer',
	'CLICK_TO_ON'				=> 'Les extensions sélectionnées seront incluses.',
	'EMPTY_PASSWD'				=> 'Il n’est pas possible de se connecter sans mot de passe',
	'WRONG_PASSWD'				=> 'Mot de passe incorrect',
	'DB_CONNECT_ERROR'			=> 'Erreur durant la connexion : %s',
	'DB_CONNECT_PASS_ERROR'		=> 'Erreur durant la connexion :',
	'TABLE_NOT_EXISTS'			=> 'Le préfixe de la table de la base de données est probablement incorrect ou la table n’existe pas.',
));
