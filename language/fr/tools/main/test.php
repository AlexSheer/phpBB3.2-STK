<?php
/**
 *
 * @package Support Toolkit - Test French language
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
	'TEST'				=> 'Informations générales',
	'DATABASE_INFO'		=> 'Base de données du serveur',
	'DBMS'				=> 'Type de la base de données',
	'PHP_INFO'			=> 'Informations concernant PHP',
	'PHP_VERSION'		=> 'Version de PHP',
	'STK_VERSION'		=> 'Version de Support Tookit',
	'MBSTRING_LOADED'	=> 'La fonctionnalité des chaînes de caractères multi-octets (module PHP <strong>mbstring</strong>) est chargée.',
	'MBSTRING_NOT_LOADED'				=> 'La fonctionnalité des chaînes de caractères multi-octets (module PHP <strong>mbstring</strong>) n’est pas chargée.',
	'ERROR_MBSTRING_NOT_LOADED_EXPLAIN'	=> 'Le module PHP <strong>mbstring</strong> ne fait pas partie de la liste des module chargés par défaut. Cela signifie que ce module est désactivé par défaut. Pour utiliser les fonctionnalités de ce module il est nécessaire de définir ce dernier sur « enable » dans la configuration de PHP. Si besoin, merci de consulter la documentation du <a href="http://php.net/manual/ru/mbstring.configuration.php">langage PHP</a>.',
));
