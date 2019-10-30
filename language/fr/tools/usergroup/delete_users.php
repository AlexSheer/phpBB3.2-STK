<?php
/**
 *
 * @package Support Toolkit - Delete Users French language
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
	'DELETE_USERS'				=> 'Suppression d’utilisateurs',
	'DELETE_USERS_EXPLAIN'		=> 'Sur cette page il est possible de supprimer les utilisateurs n’ayant rédigé aucun message et n’ayant pas participé depuis une période sélectionnée.',
	'INACTIVE_PERIOD'			=> 'Période d’inactivité',
	'DELETE_USERS_SUCESS'		=> 'Les utilisateurs ont été supprimés avec succès.',
	'DELETE_USERS_NOT_FOUND'	=> 'Les utilisateurs devant être supprimés n’ont pas été trouvés.',
	'DELETE_USERS_CONFIRM'		=> 'Confirmer la suppression de ces utilisateurs ?<br />(<strong>Attention !</strong> Supprimer un grand nombre d’utilisateurs peut prendre un certain temps. Il est nécessaire que cette page ne soit pas fermée jusqu’à la fin du traitement.)',
));
