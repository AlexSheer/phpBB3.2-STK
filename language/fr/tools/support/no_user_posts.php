<?php
/**
 *
 * @package Support Toolkit - No User Posts French language
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
	'NO_USER_POSTS'					=> 'Messages sans auteur',
	'NO_USER_POSTS_EXPLAIN'			=> 'Permet de supprimer les messages sans auteur (ce peut se produire lorsque l’utilisateur a été supprimé manuellement directement depuis la base de données du forum, sans utiliser l’outil de phpBB prévu à cet effet dans son panneau d’administration).',
	'AUTHOR_POSTS_REASSIGNED'		=> 'Membre(s) assigné(s) comme auteur de %d message(s).',
	'NO_NO_USER_POSTS'				=> 'Aucun message sans auteur n’a été trouvé.',
	'NO_AUTHOR_SELECTED'			=> 'Aucun membre n’a été sélectionné.',
	'POSTS_REASSIGNED_TO_GUEST'		=> 'L’utilisateur <b>Anonymous</b> a été assigné comme auteur de %d message(s).',
	'REASSIGN_ANONYMOUS'			=> 'Assigner l’utilisateur « Anonymous » comme auteur des messages sélectionnés',
));
