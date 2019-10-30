<?php
/**
 *
 * @package Support Toolkit - Delete Styles French language
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
	'DELETE_STYLES'				=> 'Suppression des styles personnalisés',
	'DELETE_STYLES_EXPLAIN'		=> 'Permet de supprimer tous les styles additionnels installés. Le style par défaut « <em>prosilver</em> » sera réinstallé et défini par défaut pour le forum et tous ses utilisateurs. Cliquer pour confirmer cette action.',
	'NOT_EXISTS_ PROSILVER'		=> 'Il n’y a aucun fichiers propres au style « <em>prosilver</em> ». Il est nécessaire d’envoyer les fichiers du style « <em>prosilver</em> » dans le répertoire « <em>./styles/prosilver/</em>.',
	'STYLE_UNINSTALL_SUCESS'	=> 'Le style « %s » a été supprimé avec succès de la base de données du forum !',
	'DELETE_STYLES_EMPTY'		=> 'Aucun style additionnel installé sur le forum n’a été trouvé.',
));
