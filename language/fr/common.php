<?php
/**
 *
 * @package Support Toolkit - Common French language
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
	'BACK_TOOL'							=> 'Retour vers le dernier outil',
	'BOARD_FOUNDER_ONLY'				=> 'Seuls les fondateurs du forum peuvent accéder au STK.',

	'CAT_ADMIN'							=> 'Outils pour les administrateurs',
	'CAT_ADMIN_EXPLAIN'					=> 'Les outils pour les administrateurs peuvent être utilisés par un administrateur afin de gérer des caractéristiques particulières de son forum et de résoudre des problèmes fréquents.',
	'CAT_DEV'							=> 'Outils pour les développeurs',
	'CAT_DEV_EXPLAIN'					=> 'Les outils pour les développeurs peuvent être utilisés par les développeurs ou les créateurs d’extensions pour phpBB afin de réaliser des tâches fréquentes.',
	'CAT_ERK'							=> 'Kit de réparation d’urgence (ERK)',
	'CAT_ERK_EXPLAIN'					=> 'Le kit de réparation d’urgence (ERK) est un outil séparé du STK qui a été conçu pour exécuter certains points de contrôle permettant de détecter des problèmes, liés à l’installation de phpBB, qui peuvent favoriser un dysfonctionnement sur le forum. Cliquer <a href="%s">ici</a> afin d’exécuter le ERK.',
	'CAT_MAIN'							=> 'Principal',
	'CAT_MAIN_EXPLAIN'					=> 'Support Toolkit (STK) peut être utilisé afin de régler les erreurs fréquemment rencontrées dans une installation fonctionnant sous phpBB 3.2.x/3.3.x. Il se présente comme un second « Panneau d’administration », offrant à un administrateur une multitude d’outils pouvant résoudre des problèmes fréquents qui peuvent empêcher une installation phpBB3 de fonctionner correctement.',
	'CAT_SUPPORT'						=> 'Outils de support',
	'CAT_SUPPORT_EXPLAIN'				=> 'Les outils de support peuvent être utilisés afin d’aider à restaurer une installation de phpBB 3.2.x/3.3.x qui ne fonctionne plus correctement.',
	'CAT_USERGROUP'						=> 'Outils pour les utilisateurs et les groupes',
	'CAT_USERGROUP_EXPLAIN'				=> 'Ces outils peuvent être utilisés pour gérer des utilisateurs et des groupes avec certaines fonctionnalités nativement non présentes dans phpBB 3.2.x/3.3.x.',
	'CONFIG_NOT_FOUND'					=> 'Le fichier de configuration de STK n’a pas pu être chargé. Merci de vérifier l’installation',
	'CONFIG_VERSION'					=> 'Version number in Database',
	'CONSTANT_VERSION'					=> 'Version number in /includes/constants.php',

	'DOWNLOAD_PASS'						=> 'Télécharger le fichier de mot de passe.',
	'STK_PASSWORD'						=> 'Mot de passe',

	'EMERGENCY_LOGIN_NAME'				=> 'Connexion d’urgence du STK',
	'ERK'								=> 'Kit de réparation d’urgence',

	'FAIL'								=> 'Erreur',
	'FAIL_REMOVE_PASSWD'				=> 'Impossible de supprimer le fichier de mot de passe expiré. Merci de supprimer ce fichier manuellement !',

	'GEN_PASS_FAILED'					=> 'STK n’a pas été capable de générer un nouveau mot de passe. Merci de réessayer.',
	'GEN_PASS_FILE'						=> 'Générer un fichier de mot de passe.',
	'GEN_PASS_FILE_EXPLAIN'				=> 'Si la connexion à phpBB n’est pas possible, il est possible d’utiliser la méthode d’authentification interne de STK. Pour utiliser cette méthode, il est nécessaire de <a href="%s"><strong>générer</strong></a> un nouveau fichier de mot de passe.',

	'INCORRECT_CLASS'					=> 'Classe incorrecte dans : stk/tools/%1$s.%2$s',
	'INCORRECT_PASSWORD'				=> 'Le mot de passe est incorrect',
	'INCORRECT_PHPBB_VERSION'			=> 'La version de phpBB n’est pas compatible avec cet outil. L’installation de phpBB doit au moins être mise à jour vers la version %1$s ou plus avant de pouvoir exécuter cet outil.',

	'LOGIN_STK_SUCCESS'					=> 'Connexion réalisée, redirection en cours vers STK.',

	'NOTICE'							=> 'Avertissement',
	'NO_VERSION_FILE'					=> 'STK n’a pas pu déterminer la dernière version. Merci de se rendre sur la <a href="http://phpbb.com/support/stk">section relative à STK sur phpBB.com</a> et de vérifier que la dernière version est utilisée avant de continuer à utiliser STK.',

	'REQUEST_PHPBB_VERSION'				=> 'Définir la version de phpBB',
	'REQUEST_PHPBB_VERSION_EXPLAIN'		=> 'Support Toolkit n’a pas pu identifier correctement la version de phpBB que utilisée, merci de sélectionner la version appropriée dans ce formulaire avant de continuer.<br />Cela signifie que les fichiers du forum et la version du forum sont incompatibles, probablement dû à une mise à jour incomplète. Merci de consulter les <a href="https://www.phpbb.com/community/viewforum.php?f=46">forums de support phpBB.com</a> ou les <a href="http://forums.phpbb-fr.com/support-phpbb3/">forums de support phpBB-fr.com</a> pour obtenir de l’aide et résoudre ce problème.',

	'PASS_GENERATED'					=> 'Le fichier du mot de passe STK a été généré.<br/>Le mot de passe généré est : <em>%1$s</em><br />Ce mot de passe expirera le : <span style="text-decoration: underline;">%2$s</span>. Après cette date, il est <strong>nécessaire</strong> de générer un nouveau fichier de mot de passe avant de pouvoir continuer à utiliser la fonctionnalité de la connexion d’urgence !<br /><br />Utiliser le bouton suivant afin de télécharger le fichier. Une fois ce fichier téléchargé, il est nécessaire de le transférer sur son serveur dans le répertoire « stk ».',
	'PASS_GENERATED_REDIRECT'			=> 'Une fois que le fichier du mot de passe est transféré au bon emplacement, cliquer <a href="%s">ici</a> afin de retourner sur la page de connexion.',
	'PLUGIN_INCOMPATIBLE_PHPBB_VERSION'	=> 'Cet outil n’est pas compatible avec la version de phpBB utilisée.',
	'PROCEED_TO_STK'					=> '%sContinuer vers STK%s',

	'STK_FOUNDER_ONLY'					=> 'Il est nécessaire de s’authentifier de nouveau avant de pouvoir utiliser STK.',
	'STK_LOGIN'							=> 'Connexion au STK',
	'STK_LOGIN_WAIT'					=> 'Il est nécessaire de patienter au moins trois secondes avant d’essayer de se reconnecter.',
	'STK_LOGOUT'						=> 'Déconnexion de STK',
	'STK_LOGOUT_SUCCESS'				=> 'Déconnexion de STK réalisée.',
	'STK_NON_LOGIN'						=> 'Se connecter afin d’accéder au STK.',
	'STK_OUTDATED'						=> 'L’installation de STK ne semble pas être à jour. La dernière version disponible est la <strong style="color: #79ff79;">%1$s</strong>, alors que la version installée est la <strong style="color: #FFB465;">%2$s</strong>.<br /><br />En raison de l’impact considérable de cet outil sur l’installation de phpBB, il a été désactivé jusqu’à ce qu’une mise à jour soit effectuée. Il est fortement recommandé de s’assurer que tous les logiciels fonctionnant sur son serveur soient bien à jour.<br />Pour plus d’informations concernant la dernière mise à jour, merci de consulter le <a href="%3$s">sujet de publication</a> (en anglais).<br /><br /><em>Si cet avertissement s’affiche après une mise à jour de STK, cliquer <a href="%4$s">ici</a> afin de vider le cache du contrôle de version.</em>',
	'SUPPORT_TOOL_KIT'					=> 'STK',
	'SUPPORT_TOOL_KIT_INDEX'			=> 'Index de STK',
	'SUPPORT_TOOL_KIT_PASSWORD'			=> 'Mot de passe',
	'SUPPORT_TOOL_KIT_PASSWORD_EXPLAIN'	=> 'Puisque la connexion à phpBB3 n’est plus effective, il est nécessaire de vérifier que le compte utilisateur utilisé sur le forum est fondateur en saisissant le mot de passe STK.<br /><br /><strong>Les cookies DOIVENT être autorisés par le navigateur utilisé, ou il ne sera pas possible de rester connecté(e).</strong>',

	'TOOL_INCLUTION_NOT_FOUND'			=> 'Cet outil essaie de charger un fichier (%1$s) qui n’existe pas.',
	'TOOL_NAME'							=> 'Nom de l’outil',
	'TOOL_NOT_AVAILABLE'				=> 'L’outil demandé n’est pas disponible.',

	'USING_STK_LOGIN'					=> 'La connexion en utilisant la méthode d’authentification interne au STK a été utilisée. Il est recommandé d’utiliser cette méthode <strong>uniquement</strong> lorsqu’il est impossible de se connecter à phpBB.<br />Pour désactiver cette méthode d’authentification, cliquer <a href="%1$s">ici</a>.',
	'VISITED'							=> 'Dernière visite',
	'TOTAL'								=> 'Total',

	'ERK_OK'							=> 'Le kit de réparation d’urgence n’a trouvé aucune erreur pour l’installation de phpBB.',
	'RELOAD_STK'						=> 'Cliquer <a href="%s"><b>ici</b></a> pour se rendre au STK.',
	'RELOAD_ARK'						=> 'Cliquer <a href="%s"><b>ici</b></a> pour se rendre au ERK.',
	'ANONYMOUS_MISSING'					=> 'L’outil STK a déterminé que l’utilisateur « Anonymous » utile au invités est absent de la base de données, aussi le forum ne peut fonctionner correctement.<br />
											cliquer <a href="%s"><b>ici</b></a> pour se rendre dans le kit d’urgence ERK - L’utilisateur « Anonymous » sera recréé automatiquement.',

	'ERK_NO_WHITELIST'					=> 'L’outil BOM sniffer ne parvient pas à lire la liste blanche et ne peut exécuter les tests. Merci de demander de l’assistance sur les <a href="%s">forums de support</a>.',
	'ERK_ISSUE_FOUND'					=> 'Dans le cadre du « Kit de réparation d’urgence » du Support Toolkit le ERK a vérifié les fichiers de phpBB et a déterminé que certains des fichiers contiennent un contenu incorrect susceptible de bloquer le fonctionnement du forum. Le Support Toolkit a tenté de résoudre ces problèmes et a créé une archive contenant les fichiers corrigés <em>(les fichiers de sauvegardes sont situés dans le répertoire <c>store/bom_sniffer_backup/</c>)</em>. Cette archive est située dans le répertoire <c>store/bom_sniffer/</c> directory. Pour appliquer les fichiers modifiés à son forum merci de <strong>déplacer</strong> les fichiers stockés dans le répertoire « store » dans leur emplacement correct et de se rendre de nouveau au Support Toolkit. Le toolkit va vérifier à nouveau ces fichiers et une redirection vers le ERK va se réaliser si aucun défaut n’est trouvé.<br /><br /><strong style="color: #ff0000;">Avant de déplacer les fichiers générés, merci de s’assurer que les fichiers générés sont corrects !</strong> Dans le doute merci de demander assistance auprès du <a href="http://www.phpbb.com/community/viewforum.php?f=46">forum de support</a>.',
	'ERK_STORE_WRITE'					=> 'L’outil BOM sniffer requiert que le répertoire <c>store</c> existe et soit accessible en écriture !',
	'ERK_REMOVE_DIR'					=> 'Le Support Toolkit a tenté de supprimer le répertoire de stockage du fichier corrigé de cet outil mais n’était pas en mesure de le faire. Afin que cet outil fonctionne de nouveau correctement le \'<c>%s</c>\' doit être retiré du serveur. Merci de supprimer ce répertoire manuellement et quitter le Support Toolkit.',
	'BOM_SNIFFER_WRITABLE'				=> 'L’outil BOM sniffer requiert que le répertoire du cache ' . STK_ROOT_PATH . 'existe et soit accessible en écriture !',
	'STK_FATAL_ERROR'					=> '<strong style="color: #ff0000;">Le Support Toolkit a rencontré une erreur fatale.</strong><br /><br />
											 Le Support Toolkit comprend un kit de réparation d’urgence (ERK), un outil destiné à corriger certaines erreurs pour prévenir le bon fonctionnement du forum phpBB.
											 Il est conseillé d’exécuter maintenant le ERK pour tenter de corriger l’erreur qui a été détectée.<br />
											 Pour exécuter le ERK, cliquer <a href="' . STK_ROOT_PATH . 'erk.' . PHP_EXT . '"><b>ici</b></a>.',
	'CONFIG_REPAIR'						=> 'Corriger le fichier « config.php »',
	'CONFIG_REPAIR_EXPLAIN'				=> 'Au moyen de cet outil il est possible de régénérer son fichier de configuration',
	'CONFIG_REPAIR_NO_TABLES'			=> 'Les tables de phpBB3 n’ont pas pu être trouvées dans cette base de données avec ce préfixe de table.',
	'CONFIG_REPAIR_NO_DBMS'				=> 'Impossible de déterminer le type de cette base de données.',
	'CONFIG_REPAIR_CONNECT_FAIL'		=> 'La connexion à la base de données a échoué.',
	'CONFIG_REPAIR_WRITE_ERROR'			=> '<strong style="color: #ff0000;">ERREUR : Impossible d’écrire dans le fichier « config.php ».</strong><br />Merci de copier le texte ci-dessous, et le mettre dans un fichier nommé « config.php », et placer ce dernier dans le répertoire racine de son forum.<br /><br />',

	'CONFIG_LIST'						=> 'Paramètres de configuration',
	'CONFIG_LIST_EXPLAIN'				=> 'Permet d’afficher et modifier la configuration.',
	'CLOSE'								=> 'Fermer',
	'UPDATES_AVAILABLE'					=> 'La version de phpBB utilisée n’est pas à jour. La dernière version disponible pour les mises à jour est la version %1$s<br />Cliquer sur ce lien <a href="%2$s" target="_blank" />%2$s</a> pour consulter l’annonce concernant la sortie de la dernière version, qui contient des informations supplémentaires, ainsi que des instructions pour la mise à jour de phpBB.',
	'VERSIONCHECK_FAIL'					=> 'Impossible d’obtenir l’information sur la dernière version de phpBB.',

	'SELECT_ALL'						=> 'Pour tout sélectionner, merci de déplacer le curseur dans le champ ci-dessous et appuyer sur les touches Ctrl et A (sur PC) ou les touches Cmd et A (sur Mac).<br />Un double clic sélectionne un mot et un triple clic une ligne entière.',

	'PURGE_CACHE'						=> 'Purger le cache',
	'PURGE_CACHE_CONFIRM'				=> 'Confirmer la suppression du cache.',
	'USERNAME'							=> 'Nom d’utilisateur',
	'PASSWORD'							=> 'Mot de passe',
	'SUBMIT'							=> 'Envoyer',
	'CANCEL'							=> 'Annuler',
	'FORUM_INDEX'						=> 'Index du forum',

	'FILE_WRITE_FAIL'					=> 'Impossible d’écrire dans le fichier',
	'STK_INCOMPATIBLE'					=> 'Cette version de STK est dédiée aux forums phpBB 3.2.x/3.3.x, alors que la version du forum phpBB utilisé est %1$s.',

	'PHPBB_DEBUG'						=> '[Débogueur phpBB]',
	'DEBUG_IN_FILE'						=> 'dans le fichier',
	'DEBUG_ON_LINE'						=> 'à la ligne',
));
