<?php
/**
 *
 * @package Support Toolkit - Users no groups French language
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
	'USERS_NOGROUPS'			=> 'Utilisateurs sans groupes',
	'USERS_NOGROUPS_EXPLAIN'	=> 'Permet de consulter la liste des utilisateurs n’appartenant à aucun groupe.
								Il est possible de sélectionner ces utilisateurs pour leur attribuer un groupe par défaut, ou davantage de groupes, dans lesquels ils seront placés.',
	'LOST_GROUPS_USERS'			=> 'Utilisateurs n’appartenant à aucun groupe',
	'NO_USERS_FOUND'			=> 'Aucun utilisateur n’est sans groupe.',
	'NO_USERS_SELECTED'			=> 'Au moins un utilisateur doit être sélectionné.',
	'ASSIGHN_GROUPS_SUCCESS'	=> 'Les utilisateurs sélectionnés ont été ajoutés au(x) groupe(s) avec succès !',
));
