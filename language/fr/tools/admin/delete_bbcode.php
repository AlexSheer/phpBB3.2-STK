<?php
/**
 *
 * @package Support Toolkit - Delete BBCodes French language
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2019 phpBBGuru Sheer
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
	'DELETE_BBCODE'						=> 'Suppression de BBCodes',
	'DELETE_BBCODE_PROGRESS'			=> '%1$d BBCodes traités sur %2$d…',
	'DELETE_BBCODES'					=> 'Suppression de BBCodes en cours',
	'DELETE_BBCODE_COMPLETE'			=> 'Suppression de BBCodes terminée.',
	'IDS_EMPTY'							=> 'Aucun mode de suppression de BBCodes n’a été sélectionné. Si vous ne savez pas quel mode choisir, merci de cocher la case « <strong>Suppression de BBCodes partout</strong> ». ',
	'DELETE_BBCODE_POST_IDS'			=> 'Supprimer les BBCodes uniquement parmi les messages listés',
	'DELETE_BBCODE_POST_IDS_EXPLAIN'	=> 'Permet de spécifier les ID des messages dans lesquels les BBCodes seront supprimés, séparés par une virgule, tels que par exemple : 1,2,3,5,8,13.',
	'DELETE_BBCODE_FORUMS'				=> 'Supprimer les BBCodes uniquement parmi les forums sélectionnées',
	'DELETE_BBCODE_FORUMS_EXPLAIN'		=> 'Permet de sélectionner plusieurs forums dans lesquels les BBCodes seront supprimés. Pour sélectionner plusieurs forums merci d’utiliser la combinaison de la touche CTRL (CMD sous macOS) & du clic gauche de la souris.',

	'DELETE_BBCODE_SELECT'				=> 'Sélectionner les BBCodes concernés par la suppression',
	'DELETE_BBCODE_ALL'					=> 'Suppression de BBCodes partout',
	'DELETE_BBCODE_ALL_EXPLAIN'			=> 'Permet de supprimer les BBCodes partout sur le forum. Cette option sera ignorée si des messages ou forums sont spécifiés ci-dessus. Merci de noter que cet outil peut potentiellement endommager votre base de données au-delà de toute réparation ; c’est pourquoi, <strong>il est nécessaire d’effectuer une sauvegarde de la base de données du forum avant d’utiliser cet outil</strong>. Aussi, cet outil peut mettre un certain temps afin d’effectuer les tâches demandées selon la cible sélectionnée (quelques messages, forums ou le forum au complet).',



));
