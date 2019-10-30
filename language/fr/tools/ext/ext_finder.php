<?php
/**
 *
 * @package Support Toolkit - Ext Finder French language
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
	'EXT_TABLE_FINDER'			=> 'Tables',
	'EXT_TABLE_FINDER_EXPLAIN'	=> 'Permet d’obtenir des informations concernant l’extension, qui utilise cette table :',
	'TABLE'						=> 'Table',

	'EXT_COLUMN_FINDER'			=> 'Colonnes',
	'EXT_COLUMN_FINDER_EXPLAIN'	=> 'Permet d’obtenir des informations concernant l’extension, qui utilise cette colonne :',
	'COLUMN'					=> 'Colonne',

	'EXT_CONFIG_FINDER'			=> 'Configurations',
	'EXT_CONFIG_FINDER_EXPLAIN'	=> 'Permet d’obtenir des informations concernant l’extension, qui utilise ces paramètres de configurations :',
	'CONFIG'					=> 'Paramètre',

	'EXT_MODULE_FINDER'			=> 'Modules',
	'EXT_MODULE_FINDER_EXPLAIN'	=> 'Permet d’obtenir des informations concernant l’extension, qui utilise ce module :',
	'MODULE'					=> 'Module',

	'EXT_PERM_FINDER'			=> 'Permissions',
	'EXT_PERM_FINDER_EXPLAIN'	=> 'Permet d’obtenir des informations concernant l’extension, qui utilise cette permission :',
	'PERMISSION'				=> 'Permission',

	'PATH'				=> 'CHEMIN, RELATIF ./ext',
	'INFO'				=> 'INFORMATION (nom / version - description)',
	'NOT_IN_EXT'		=> '<em>Élément ne faisant pas partie d’une extension, son nom est inconnu</em>',

	'EXTRA_EXPLAIN'		=> 'Statut de cette extension, son nom, sa version ainsi que sa description. Les extensions activées sont <b style="color: #282">surlignées en vert</b>.',
));
