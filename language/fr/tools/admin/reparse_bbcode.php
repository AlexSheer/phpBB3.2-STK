<?php
/**
 *
 * @package Support Toolkit - Reparse BBCode French language
 * French translation by phpBB-fr http://www.phpbb-fr.com & Galixte (http://www.galixte.com)
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
	'REPARSE_ALL'				=> 'Réanalyser tous les BBCodes',
	'REPARSE_ALL_EXPLAIN'		=> 'Si cette option est activée, la réanalyse du BBCode vérifiera tout le contenu du forum. Par défaut, l’outil réanalysera seulement les messages, les messages privés et les signatures qui ont été précédemment analysés par phpBB. Cette option sera ignorée si des messages ou des messages privés ont été spécifiés ci-dessus.',
	'REPARSE_BBCODE'			=> 'Réanalyser le BBCode',
	'REPARSE_BBCODE_COMPLETE'	=> 'Les BBCodes ont été réanalysés.',
	'REPARSE_BBCODE_PROGRESS'	=> 'Étape %1$d terminée. Début de l’étape %2$d dans un court instant…',
	'REPARSE_BBCODE_SWITCH_MODE'	=> array(
		1	=> 'Réanalyse des messages terminée, début de la réanalyse des messages privés.',
		2	=> 'Réanalyse des messages privés terminée, début de la réanalyse des signatures.',
	),
	'REPARSE_BBCODE_MODE'			=> array(
		0	=> 'Réanalyse des messages en cours.',
		1	=> 'Réanalyse des messages privés en cours.',
		2	=> 'Réanalyse des signatures en cours.',
	),
	'REPARSE_IDS_INVALID'			=> 'Les IDs envoyés ne sont pas valides. Merci de s’assurer que chaque ID soit séparé par une virgule (exemple : 1,2,3,5,8,13).',
	'REPARSE_IDS_EMPTY'				=> 'Aucun mode de réanalyse n’a été sélectionné. Si choisir un mode n’est pas évident, vérifier la case <strong>Réanalyser tous les BBCodes</strong>. ',
	'REPARSE_POST_IDS'				=> 'Réanalyser les messages spécifiques',
	'REPARSE_POST_IDS_EXPLAIN'		=> 'Réanalyse seulement les messages spécifiques. Chaque ID doit être séparé par une virgule (exemple : 1,2,3,5,8,13).',
	'REPARSE_PM_IDS'				=> 'Réanalyser les messages privés spécifiques',
	'REPARSE_PM_IDS_EXPLAIN'		=> 'Réanalyse seulement les messages privés spécifiques. Chaque ID doit être séparé par une virgule (exemple : 1,2,3,5,8,13).',
	'REPARSE_FORUMS'				=> 'Réanalyser les messages de forums spécifiques',
	'REPARSE_FORUMS_EXPLAIN'		=> 'Sélectionner plusieurs forums tout ou partie en utilisant la combinaison de la souris et du clavier.',
	'REPARSE_SIG'					=> 'Réanalyser uniquement les signatures des membres',
	'REPARSE_SIG_EXPLAIN'			=> 'Permet de réanalyser uniquement les BBCodes présents dans les données utilisateur.',
	'CREATE_BACKUP_TABLE'			=> 'Créer une sauvegarde',
	'CREATE_BACKUP_TABLE_EXPLAIN'	=> 'Une copie de la table des BBCodes de la base de données sera créée, à partir de laquelle il sera possible de restaurer les messages en cas de panne ou d’arrêt d’urgence.'
));
