<?php
/**
 *
 * @package Support Toolkit - Auto Cookies French language
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
	'AUTO_COOKIES'				=> 'Automatisation des cookies',
	'AUTO_COOKIES_EXPLAIN'		=> 'Cet outil permet de modifier les réglages des cookies de son forum. Les réglages qui sont suggérés sont corrects dans la plupart des cas. Si l’exactitude des réglages n’est pas certaine, merci de rechercher de l’aide dans le forum de support avant de réaliser une mauvaise manipulation qui pourrait rendre impossible toute connexion à son forum.',

	'COOKIE_SETTINGS_UPDATED'	=> 'Les réglages des cookies ont été mis à jour.',
	'COOKIE_DOMAIN'				=> 'Domaine du cookie',
	'COOKIE_NAME'				=> 'Nom du cookie',
	'COOKIE_PATH'				=> 'Chemin du cookie',
	'COOKIE_SECURE'				=> 'Cookie sécurisé',
	'COOKIE_SECURE_EXPLAIN'		=> 'Si votre site Internet est accessible par l’intermédiaire du protocole SSL (https://), activez cette option sinon laissez sur « Désactivé ». Si vous activez cette option alors que votre site Internet n’est pas accessible par le protocole SSL, des erreurs se produiront lors des redirections.',
));
