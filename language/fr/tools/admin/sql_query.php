<?php
/**
 *
 * @package Support Toolkit - SQL Query French language
 * French translation by phpBB-fr http://www.phpbb-fr.com & Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2017 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'ERROR_QUERY'					=> 'Requête contenant l’erreur',

	'NO_RESULTS'					=> 'Aucun résultat',
	'NO_SQL_QUERY'					=> 'Saisir une requête à exécuter.',

	'QUERY_RESULT'					=> 'Résultats de la requête',

	'SHOW_RESULTS'					=> 'Afficher les résultats',
	'SQL_QUERY'						=> 'Exécuter une requête SQL',
	'SQL_QUERY_EXPLAIN'				=> 'Permet de saisir la requête SQL à exécuter. L’outil remplacera « phpbb_ » par le préfixe de table utilisé.<br />Si l’option « Afficher les résultats » est cochée, l’outil affichera les résultats de la requête <em>(s’il y en a)</em>.',

	'SQL_QUERY_LEGEND'				=> 'Requête SQL',
	'SQL_QUERY_SUCCESS'				=> 'La requête SQL a été exécutée.',
));
