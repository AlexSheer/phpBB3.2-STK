<?php
/**
 *
 * @package Support Toolkit - Database Cleaner French language
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
	'ACP_EXTENSION_GROUPS'			=> 'Groupes d’extensions des fichiers joints',
	'ACP_MODULES_SETTINGS'			=> 'Recherche de nouveaux modules ajoutés',

	'BOARD_DISABLE_REASON'			=> 'Le forum est actuellement désactivé car une maintenance de la base de données est en cours. Merci de revenir ultérieurement.',
	'BOARD_DISABLE_SUCCESS'			=> 'Le forum a été désactivé.',

	'COLUMNS'						=> 'Colonnes',
	'CONFIG_SETTINGS'				=> 'Paramètres de configuration',
	'CONFIG_UPDATE_SUCCESS'			=> 'Les paramètres de configuration ont été mis à jour.',
	'CONTINUE'						=> 'Continuer',

	'DATABASE_CLEANER'				=> 'Nettoyeur de base de données',
	'DATABASE_CLEANER_BREAK'		=> 'Le nettoyeur de base de données a été interrompu !<br /><br />Le cache a été purgé et le forum réactivé.',
	'DATABASE_CLEANER_EXTRA'		=> 'Tous les autres sont des objets supplémentaires ajoutés par des modifications. <strong>Si la case est cochée, ils seront supprimés</strong>.',
	'DATABASE_CLEANER_MISSING'		=> 'Tous les champs surlignés sur un fond rouge comme celui-ci sont des objets manquants qui devraient être ajoutés. <strong>Si la case est cochée, ils seront ajoutés</strong>.',
	'DATABASE_CLEANER_SUCCESS'		=> 'Le nettoyeur de base de données a terminé toutes les tâches !<br /><br />Merci de s’assurer de sauvegarder à nouveau sa base de données.',
	'DATABASE_CLEANER_WARNING'		=> 'Cet outil n’apporte AUCUNE GARANTIE et les utilisateurs de cet outil devraient sauvegarder entièrement leur base de données en cas d’échec.<br /><br />Avant de continuer, Merci de s’assurer de détenir une sauvegarde de sa base de données !',
	'DATABASE_CLEANER_WELCOME'		=> 'Bienvenue sur l’outil de nettoyage de la base de données !<br /><br />Cet outil a été créé afin de supprimer les colonnes, les lignes et les tables supplémentaires de la base de données qui ne sont pas présentes par défaut dans l’installation de phpBB3, et il ajoute les éléments manquants de la base de données qui peuvent être nécessaires.<br /><br />Pour continuer, merci de cliquer sur le bouton « Continuer » afin de commencer à utiliser l’outil de nettoyage de la base de données (merci de noter que le forum sera désactivé le temps de l’opération).',
	'DATABASE_COLUMNS_SUCCESS'		=> 'Les colonnes de la base de données ont été mises à jour.',
	'DATABASE_INDEXES_SUCCESS'		=> 'Les indexes ont été mis à jour avec succès !',
	'DATABASE_TABLES'				=> 'Tables de la base de données',
	'DATABASE_TABLES_SUCCESS'		=> 'Les tables de la base de données ont été mises à jour.',
	'DATABASE_ROLE_DATA_SKIP'		=> 'La restauration des rôles système a été ignorée',
	'DATABASE_ROLE_DATA_SUCCESS'	=> 'Les rôles systèmes de phpBB ont été restaurés.',
	'DATABASE_ROLES_SUCCESS'		=> 'Les rôles ont été mis à jour.',
	'DATAFILE_NOT_FOUND'			=> 'Support Toolkit n’a pas été capable de trouver le fichier de données correspondant à la version de phpBB !',

	'EMPTY_PREFIX'					=> 'Aucun préfixe de base de données',
	'EMPTY_PREFIX_CONFIRM'			=> 'Le nettoyeur de base de données permet d’apporter des modifications aux tables de la base de données, mais étant donné qu’aucun préfixe de table n’est utilisé, cela peut altérer des tables n’ayant aucun rapport avec phpBB. Poursuivre ?',
	'EMPTY_PREFIX_EXPLAIN'			=> 'Le nettoyeur de base de données a déterminé qu’aucun préfixe de table n’est utilisé concernant les tables de phpBB. Le nettoyeur de base de données va devoir alors vérifier <strong>l’intégralité</strong> des tables dans la base de données. Merci d’être prudent(e) lors de son exécution et de s’assurer d’avoir exclu de la sélection toutes les tables n’ayant aucun rapport avec phpBB car elles peuvent être altérées par cet outil.<br />Si un doute est présent sur la manipulation à suivre, demander de l’aide dans les <a href="https://www.phpbb.com/community/viewforum.php?f=46">forums de support phpBB.com</a> ou les <a href="http://forums.phpbb-fr.com/support-phpbb3/">forums de support phpBB-fr.com</a>.',
	'ERROR'							=> 'Erreur',
	'EXTRA'							=> 'Supplémentaire',
	'EXTENSION_FILE_GROUPS'			=> 'Extensions des fichiers joints',
	'EXTENSION_GROUPS_SETTINGS'		=> 'Paramètres des groupes d’extensions',
	'EXTENSION_GROUPS_SUCCESS'		=> 'Les groupes d’extensions ont été réinitialisés.',
	'EXTENSIONS_SUCCESS'			=> 'Les extensions ont été réinitialisées.',

	'FINAL_STEP'					=> 'Ceci est l’étape finale.<br /><br />Nous allons à présent réactiver le forum et purger son cache.',

	'GO_TO_ACP'						=> ' --&raquo; se rendre à la gestion du module ',

	'INSTRUCTIONS'					=> 'Instructions',
	'INTRODUCTION'					=> 'Recommencer',
	'INDEXES'						=> 'Index des tables de la base de données',

	'MISSING'						=> 'Manquant',
	'MODULE_ADD'					=> 'Ajouter un module',
	'MODULE_ALREADY_EXIST'			=> 'Le module existe déjà',
	'MODULE_UPDATE_SUCCESS'			=> 'Les modules ont été mis à jour.',

	'NEXT_STEP'						=> 'Prochaine étape',
	'NO_BOT_GROUP'					=> 'Impossible de réinitialiser les robots, le groupe des robots est manquant.',
	'NO_PARENT'						=> 'Le module parent n’existe pas.<br />Erreur',
	'NO_PARENTS'						=> 'No parents',

	'PERMISSION_SETTINGS'			=> 'Options des permissions',
	'PERMISSION_UPDATE_SUCCESS'		=> 'Les réglages des permissions ont été mis à jour.',
	'PHPBB_VERSION_NOT_SUPPORTED'	=> 'La version de phpBB3 n’est pas supportée (ou certains fichiers de Support Toolkit sont manquants).<br />phpBB 3.0.0+ devrait être supporté, mais il se peut que la mise à jour de cet outil prenne un certain temps avant d’être disponible, ce qui est souvent le cas lorsqu’une nouvelle version de phpBB 3.0 vient de sortir.',

	'QUIT'							=> 'Quitter',

	'RESET_ACP_MODULES_SKIP'		=> 'Vérification des nouveaux modules oubliés',
	'RESET_ACP_MODULE_SUCCESS'		=> 'Vérification des nouveaux modules terminée',
	'RESET_BOTS'					=> 'Réinitialiser les robots',
	'RESET_BOTS_EXPLAIN'			=> 'Confirmer la réinitialisation de la liste des robots avec celle définie par défaut dans phpBB3. Tous les robots existants seront supprimés afin d’être remplacés par les robots présents par défaut.',
	'RESET_BOTS_SKIP'				=> 'La réinitialisation du robot a été ignorée',
	'RESET_BOT_SUCCESS'				=> 'Les robots ont été réinitialisés.',
	'RESET_MODULES'					=> 'Réinitialiser les modules',
	'RESET_MODULES_EXPLAIN'			=> 'Confirmer la réinitialisation des modules avec les modules présents par défaut dans phpBB3. Tous les modules existants seront supprimés afin d’être remplacés par les modules présents par défaut.',
	'RESET_MODULES_SKIP'			=> 'La réinitialisation du module a été ignorée',
	'RESET_MODULE_SUCCESS'			=> 'Les modules ont été réinitialisés.',
	'RESET_REPORT_REASONS'			=> 'Réinitialiser les raisons des rapports',
	'RESET_REPORT_REASONS_EXPLAIN'	=> 'Confirmer la réinitialisation des raisons des rapports avec les valeurs par défaut. Cela supprimera toutes les raisons des rapports qui ont été ajoutées !',
	'RESET_REPORT_REASONS_SKIP'		=> 'Les raisons des rapports N’ONT PAS été réinitialisées.',
	'RESET_REPORT_REASONS_SUCCESS'	=> 'Les raisons des rapports ont été réinitialisées.',
	'RESET_ROLE_DATA'				=> 'Réinitialiser les données des rôles',
	'RESET_ROLE_DATA_EXPLAIN'		=> 'Cette étape réinitialisera les rôles système de phpBB avec les valeurs par défaut, il est fortement recommandé d’exécuter cela si des modifications ont été apportées lors de l’étape précédente.',
	'ROLE_SETTINGS'					=> 'Réglages des rôles',
	'ROWS'							=> 'Lignes',

	'SECTION_NOT_CHANGED_TITLE'	=> array(
		'tables'			=> 'Tables non modifiées',
		'indexes'			=> 'Index non modifiés',
		'columns'			=> 'Colonnes non modifiées',
		'config'			=> 'Configuration non modifiée',
		'extension_groups'	=> 'Groupes d’extensions non modifiés',
		'extensions'		=> 'Extensions non modifiées',
		'permissions'		=> 'Permissions non modifiées',
		'groups'			=> 'Groupes non modifiés',
		'roles'				=> 'Rôles non modifiés',
		'final_step'		=> 'Étape finale',
		'acp_modules'		=> 'Recherche de nouveaux modules ou modules manquants',
	),
	'SECTION_NOT_CHANGED_EXPLAIN'	=> array(
		'tables'			=> 'Les tables de la base de données n’ont pas été modifiées',
		'indexes'			=> 'Les index n’ont aucune valeur manquante',
		'columns'			=> 'Les colonnes de la base de données n’ont pas été modifiées',
		'config'			=> 'La table de configuration n’a aucune nouvelle valeur ou valeur manquante',
		'extension_groups'	=> 'La table des groupes d’extensions n’a aucune nouvelle valeur ou n’a aucune valeur manquante',
		'extensions'		=> 'Les extensions par défaut n’ont pas été modifiées',
		'permissions'		=> 'Il n’y a aucune modification dans les tables des permissions',
		'groups'			=> 'Il n’y a aucune modification dans les groupes système de phpBB',
		'roles'				=> 'Il n’y a aucun rôle ajouté ou supprimé',
		'final_step'		=> 'Cette dernière étape videra le cache et réactivera le forum.',
		'acp_modules'		=> 'Aucun nouveau module ou modules manquants',
	),
	'SKIP_AND_GO'					=> 'Ignorer et poursuivre',
	'SKIP_TO'						=> 'Ignorer',
	'SKIP_EXPLAIN'					=> 'Permet d’ignorer l’étape et de poursuivre à l’étape suivante indiquée dans la liste ci-dessous :',
	'SUCCESS'						=> 'Succès',
	'SYSTEM_GROUPS'					=> 'Vérification des groupes',
	'SYSTEM_GROUP_UPDATE_SUCCESS'	=> 'Les groupes systèmes ont été réinitialisés.',

	'TYPE'							=> 'Type',

	'UNSTABLE_DEBUG_ONLY'			=> 'Le nettoyeur de base de données ne peut s’exécuter sur les versions instables de phpBB <em>(dev, a, b, RC)</em> que lorsque « DEBUG » est activé dans le fichier « config.php ».',
	'UNDEFINED'						=> 'Non défini',

	'ARCHIVES'				=> 'Archives',
	'DOCUMENTS'				=> 'Documents',
	'DOWNLOADABLE_FILES'	=> 'Fichiers téléchargeables',
	'FLASH_FILES'			=> 'Fichiers Flash',
	'IMAGES'				=> 'Images',
	'PLAIN_TEXT'			=> 'Fichiers texte',
	'QUICKTIME_MEDIA'		=> 'Fichiers Quicktime',
	'REAL_MEDIA'			=> 'Fichiers RealMedia',
	'WINDOWS_MEDIA'			=> 'Fichiers Windows Media',
));
