<?php
/**
 *
 * @package Support Toolkit - Prune Styles French language
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
	'PRUNE_STYLES'				=> 'Vérification des fichiers de style',
	'PRUNE_STYLES_EXPLAIN'		=> 'Permet de contrôler la présence des éléments nécessaires aux styles installés. Si certains éléments s’avèrent manquants le style sera supprimé. Cliquer pour confirmer cette action.',
	'PRUNE_STYLES_SUCCESS'		=> 'Suppression effectuée.',
	'STYLE_UNINSTALL_DEPENDENT'	=> 'Le style « %s » ne peut être désinstallé car il possède un ou plusieurs styles enfants (hérités).',
	'STYLE_UNINSTALL_SUCESS'	=> 'Le style « %s » a été désinstallé avec succès !',
	'PRUNE_STYLES_EMPTY'		=> 'Aucun style additionnel installé sur le forum et comportant des éléments manquants n’a été trouvé.',
));
