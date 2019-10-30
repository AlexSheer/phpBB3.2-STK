<?php
/**
 *
 * @package Support Toolkit - DB Optimizer French language
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
	'OPTIMIZE_TABLES'			=> 'Optimisation des tables de la BDD',
	'OPTIMIZE_TABLES_EXPLAIN'	=> 'Cherche les tables de la base de données ayant besoin d’une défragmentation et une optimisation.',
	'GO'						=> 'Optimiser',
	'FRAGMENTED'				=> 'Fragmentés',
	'CREATE_TIME'				=> 'Créée le',
	'UPDATE_TIME'				=> 'Dernière mise à jour',
	'CHECK_TIME'				=> 'Vérifiée le',
	'NOT_FOUND' 				=> 'Aucune table ne requiert une optimisation',
	'TABLE_NAME'				=> 'Table',
	'TABLE_SIZE'				=> 'Utilisés',
	'ALL'						=> 'Total : ',
	'SUCESS'					=> 'Les tables sélectionnées ont été optimisées avec succès',
	'NOTHING'					=> 'Aucune sélection',
	'OPTIMIZER_MESSAGE'			=> '<b>Attention !</b> Selon la taille des tables et l’importance de la fragmentation, l’optimisation pourrait prendre un certain temps.<br />Merci de ne pas quitter cette page jusqu’à la fin de l’optimisation.',
));
