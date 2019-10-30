<?php
/**
 *
 * @package Support Toolkit - User Copy Permissions French language
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
	'USER_COPY_PERM'					=> 'Copier les permissions des utilisateurs',
	'USER_COPY_PERM_EXPLAIN'			=> 'Permet de copier toutes les permissions des utilisateurs : utilisateurs, modérateurs, administrateurs et locales.',
	'COPY_USER_PERMISSIONS_EXPLAIN'		=> 'Sélectionner l’utilisateur dont les permissions seront copiées',
	'COPY_USER_PERMISSIONS_OK'			=> 'Les permissions ont été copiées avec succès.',
	'USERS_IDENTICAL'					=> 'Il n’est pas pas possible de transférer les permissions.',
	'FIND_FROM_USER'					=> 'Nom d’utilisateur dont les permissions seront copiées',
	'ID_FROM'							=> 'ID de l’utilisateur dont les permissions seront copiees',
	'FIND_TO_USER'						=> 'Nom d’utilisateur vers qui les permissions seront transférées',
	'ID_TO'								=> 'ID de l’utilisateur vers qui les permissions seront transférées',
));
