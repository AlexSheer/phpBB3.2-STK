<?php
/**
 *
 * @package Support Toolkit - SRT Generator French language
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
// --------------------------------------------------------------------------------------------
// For the time being this file isn't translatable. The Support Toolkit will always force the
// English version when the "Support Request Generator" is ran.
//

$lang = array_merge($lang, array(
	'COMPILED_TEMPLATE_EXPLAIN'		=> 'Ci-dessous se trouve une copie du modèle de demande de support. Cliquer ci-dessous pour le copier dans son presse-papiers, puis créer un nouveau message dans les <a href="https://www.phpbb.com/community/viewforum.php?f=556">forums de support phpBB.com</a> ou les <a href="http://forums.phpbb-fr.com/support-phpbb32/">forums de support phpBB-fr.com</a> avec ces informations. Si un sujet de support existe déjà concernant la thématique abordée, merci de copier le modèle dans une réponse à son sujet existant plutôt que d’en créer un nouveau.',
	'COULDNT_LOAD_SRT_ANSWERS'		=> 'Le générateur de modèle de demande de support n’a pas pu charger les réponses. Vérifier que l’outil STK a été correctement démarré.',
	'SRT_GENERATOR'					=> 'Générateur de modèle de demande de support',
	'SRT_GENERATOR_LANDING'			=> 'Générateur de modèle de demande de support (SRT)',
	'SRT_GENERATOR_LANDING_CONFIRM'	=> 'Bienvenue sur le générateur de modèle pour la demande de support à l’équipe d’assistance. C’est le moyen le plus rapide et efficace pour compléter notre modèle de demande de support. Le générateur posera une série de huit à dix questions qui sont utiles pour effectuer un diagnostic. Les réponses seront compilées dans une liste qui peut être copiée et collée dans son sujet de support.<br />Cet outil STK fait la même chose que le <a href="https://www.phpbb.com/support/srt/?step=1">SRT Generator sur www.phpbb.com</a>, mais certaines questions sont pré-remplies.<br /><br /> Confirmer l’exécution du Générateur SRT.',
	'SRT_NO_CACHE'					=> 'Le générateur de modèle pour la demande de support utilise le système de cache de phpBB pour stocker des informations à chaque étape. Aucun cache n’est utilisé pour phpBB ce qui n’est pas compatible avec cet outil. Merci d’utiliser un cache pour utiliser cet outil ou se rendre sur le <a href="https://www.phpbb.com/support/srt/?step=1">générateur en ligne SRT</a>',
	'START_OVER'					=> 'Tout recommencer',
	'NO_ANSVER'						=> 'La réponse n’est pas fournie',
	'BY_SRT_GENERATOR'				=> 'Créé par le générateur de demande d’assistance SRT (Support Request Template Generator)',
));

// Step 1 strings
$lang = array_merge($lang, array(
//	'STEP1_CONVERT'			=> '',
//	'STEP1_CONVERT_EXPLAIN'	=> '',
	'STEP1_MOD'				=> 'Le problème est-il lié à une extension ?',
	'STEP1_MOD_EXPLAIN'		=> 'Le problème a-t-il commencé après l’installation ou la suppression d’une extension ?',
	'STEP1_MOD_ERROR'		=> 'Les demandes de support pour des problèmes liés aux extensions (par exemple, si une extension vient d’être installée et que des erreurs sont constatées) doivent être postées dans le sujet où l’extension a été téléchargée. Si l’extension est issue d’un autre forum, Merci de s’adresser à celui-ci.<br /><br />Se rendre dans les <a href="http://www.phpbb.com/community/viewforum.php?f=451">forums de support des extensions pour phpBB.com</a> ou les <a href="http://forums.phpbb-fr.com/support-des-extensions/">forums de support des extensions pour phpBB-fr.com</a>.',
	'STEP1_HACKED'			=> 'Confirmer le piratage de son forum.',
	'STEP1_HACKED_EXPLAIN'	=> 'Permet de sélectionner « Oui » pour du support car le forum a été effacé ou endommagé d’une façon quelconque.',
	'STEP1_HACKED_ERROR'	=> 'Si le forum a été piraté, il est nécessaire de déposer un rapport au Suivi des Enquêtes sur les Incidents au lieu de poster dans le forum de support afin qu’aucune information privée ne soit divulguée.<br /><br />Lire <a href="http://www.phpbb.com/community/viewtopic.php?f=46&t=543171#iit">ce sujet</a> (en anglais) pour les instructions à suivre.',
));

// The questions
$lang = array_merge($lang, array(
	'SRT_QUESTIONS'	=> array(
		'step2'	=> array(
			'phpbb_version'		=> 'Quelle est la version de phpBB utilisée ?',
			'board_url'			=> 'Quelle est l’URL du forum utilisé ?',
			'dbms'				=> 'Type/version de la base de données utilisé ?',
			'php'				=> 'Quelle est la version du langage PHP utilisé ?',
			'host_name'			=> 'Quel est l’hébergeur du forum ?',
			'install_type'		=> 'De quelle manière le forum a-t-il été installé ?',
			'inst_converse'		=> 'Est-ce que le forum est une nouvelle installation ou une conversion ?',
			'mods_installed'	=> 'Des extensions sont-elles installées ?',
			'registration_req'	=> 'Est-il nécessaire de s’enregistrer pour reproduire ce problème ?',
		),
		'step3'	=> array(
			'installed_styles'		=> 'Quels sont les styles actuellement installés ?',
			'installed_languages'	=> 'Quelle(s) langue(s) le forum utilise t-il actuellement ?',
			'xp_level'				=> 'Quel est le niveau d’expérience revendiqué ?',
			'problem_started'		=> 'Quand le problème a-t-il commencé ?',
			'problem_description'	=> 'Décrire le problème.',
			'installed_mods'		=> 'Quelles extensions ont été installées ?',
			'test_username'			=> 'Quel pseudo peut être utilisé pour voir ce problème ?',
			'test_password'			=> 'Quel mot de passe peut être utilisé pour voir ce problème ?',
		),
	),
));

// Explain lines for the questions
$lang = array_merge($lang, array(
	'SRT_QUESTIONS_EXPLAIN'	=> array(
		'step2'	=> array(
			'phpbb_version'		=> 'Le générateur de SRT n’a pas pu déterminer quelle version de phpBB est utilisée, merci de sélectionner la version appropriée. Pour trouver cette information, se connecter sur son forum puis se rendre en bas de page. Cliquer sur « Panneau d’administration » puis cliquer sur l’onglet « Système ».',
			'board_url'			=> 'L’URL son forum est l’adresse utilisée pour accéder à ce dernier. La plupart des problèmes sont plus rapidement résolus si l’on peut voir son Panneau d’administration. Si l’information ne peut être communiquée, merci d’indiquer « n/a ».',
			'dbms'				=> 'Pour déterminer la version et le type de la base de données utilisée, se rendre dans le « Panneau de Contrôle d’Administration (PCA) », onglet « Général », chercher « Serveur de base de données » dans « Statistiques du forum ».',
			'gzip'				=> 'Compression GZip activée',
			'php'				=> 'Pour déterminer la version de PHP utilisée, se rendre dans le « Panneau de Contrôle d’Administration (PCA) », onglet « Général », cliquer sur  « Informations PHP » dans « Accès rapide » et chercher « PHP Version x.y.z ».',
			'host_name'			=> 'Certains problèmes rencontrés avec phpBB peuvent être attribués à des hébergeurs particuliers. Ce champ doit être rempli avec le prestataire de service qui fournit le hébergement Web (tel que GoDaddy, Yahoo!, 1&1, etc.). Si le forum est auto-hébergé, merci de le le signaler. De même, si le nom de l’hébergeur est inconnu, merci de le signaler aussi.',
			'install_type'		=> 'Si le forum a été installé en téléchargeant les fichiers de phpBB, puis en les transférant sur son hébergeur, puis en accédant à l’installateur, sélectionner « J’ai installé le forum tout seul ». Si une aide a été demandé à quelqu’un afin d’effectuer l’installation, sélectionner « Quelqu’un d’autre à installé ce forum pour moi ». Si un outil automatisé a été utilisé tel que « Fantastico », sélectionner « J’ai utilisé un outil fourni par mon hébergeur ».',
			'inst_converse'		=> '« Nouvelle installation » signifie que le forum n’existait pas avant l’installation de phpBB. Si le forum a été récemment mis à jour à partir d’une version antérieure de phpBB3 et que les problèmes sont apparus après, sélectionner « Mis à jour depuis une version antérieure de phpBB3 ». « Conversion d’un autre logiciel » signifie que le forum a été installé précédemment comme un autre logiciel (exemple PHP-Nuke), puis plus tard converti à phpBB.',
			'mods_installed'	=> 'Les extensions sont souvent la cause de nombreux problèmes avec phpBB. Cette information peut aider à déterminer la cause exacte du problème.',
			'registration_req'	=> 'Sélectionner « Oui » si l’on doit être inscrit et connecté pour voir le problème.',
		),
		'step3'	=> array(
			'installed_styles'		=> 'Les anciens styles sont souvent la cause de nombreux problèmes. Si les styles installés sont inconnus, se rendre dans le Panneau de Contrôle d’Administration (PCA) et cliquer sur l’onglet « Styles ».',
			'installed_languages'	=> 'Les anciens packs de langue sont souvent la cause de nombreux problèmes. Si les packs de langue installés sont inconnus, se rendre dans le Panneau de Contrôle d’Administration (PCA), onglet « Système », « Tâches générales » et cliquer sur « Langues » dans la liste de gauche.',
			'xp_level'				=> 'Merci de sélectionner l’option qui décrit le mieux ses compétences en matière d’utilisation de phpBB.',
			'problem_started'		=> 'Merci d’indiquer les actions effectuées (mise à jour de son forum, installation d’extensions, etc.) avant que le problème ne devienne perceptible.',
			'problem_description'	=> 'Lors de la description du problème, Merci d’être aussi précis que possible. Indiquer les informations concernant le moment où le problème est apparu, les étapes pour reproduire le problème et toutes autres informations utiles.',
			'installed_mods'		=> 'Merci d’être le plus précis possible en indiquant les extensions installées. Cette information contribue beaucoup à nous aider pour déterminer la cause du problème.',
			'test_username'			=> 'Merci de fournir les identifiants d’un compte de test pouvant être utilisé pour afficher le problème. <strong>Ne pas</strong> donner ces informations si cela requière des privilèges élevés.',
			'test_password'			=> 'Merci de fournir le mot de passe d’un compte de test pouvant être utilisé pour afficher le problème. <strong>Ne pas</strong> donner ces informations si cela requière des privilèges élevés.',
		),
	),
));

// Language strings that are used for building dropdown boxes
$lang = array_merge($lang, array(
	'SRT_DROPDOWN_OPTIONS'	=> array(
		'step2'	=> array(
			'install_type'	=> array(
				null			=> 'Merci de sélectionner une réponse',
				'myself'		=> 'J’ai utilisé le package de téléchargement de phpBB.com',
				'third'			=> 'J’ai utilisé le package de téléchargement d’un autre site',
				'someone_else'	=> 'Une autre personne a installé mon forum pour moi',
				'automated'		=> 'J’ai utilisé l’outil fourni par mon hébergeur',
			),
			'inst_converse'	=> array(
				null			=> 'Merci de sélectionner une réponse',
				'fresh'				=> 'Nouvelle installation',
				'phpbb_update'		=> 'Mise à jour depuis une version antérieure de phpBB3',
				'convert_phpbb2'	=> 'Conversion depuis phpBB 2.0.x',
				'convert_phpbb30'	=> 'Conversion depuis phpBB 3.0.x',
				'convert_phpbb31'	=> 'Conversion depuis phpBB 3.1.x',
				'convert_other'		=> 'Conversion d’un autre logiciel',
			)
		),
		'step3'	=> array(
			'xp_level'		=> array(
				null			=> 'Merci de sélectionner une réponse',
				'new_both'		=> 'Débutant PHP et phpBB',
				'new_phpbb'		=> 'Débutant phpBB mais pas PHP',
				'new_php'		=> 'Débutant PHP mais pas phpBB',
				'comfort'		=> 'À l’aise avec PHP et phpBB',
				'experienced'	=> 'Expérimenté avec PHP et phpBB',
			),
		),
	),
));
