<?php
/**
 *
 * @package Support Toolkit - Config List French language
 * French translation by Galixte (http://www.galixte.com)
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
	'NO_CONFIG_TITLE'					=> 'Aucun paramètre',
	'NO_CONFIG_TEXT'					=> 'Aucun paramètre à afficher',

	'CONFIG_PURPOSE'					=> 'Proposition',
	'CONFIG_NAME'						=> 'Paramètre',
	'CONFIG_VALUE'						=> 'Valeur',
	'IS_DYNAMIC'						=> 'Est dynamique',
	'CONFIG_CHANGED_SUCCESS'			=> 'Les valeurs de la configuration ont été modifiées avec succès',
	'CLICK_HERE_TO_CHANGE'				=> 'Cliquer ici pour changer la configuration (les modifications prendront effet <b>immédiatement !</b>)',
	'TOTAL_ITEMS'						=> 'Total',
	'CRON_TASKS'						=> 'Tâches du « cron »',
	'ATTACHMENTS'						=> 'Paramètres des fichiers joints',
	'AVATARS'							=> 'Paramètres des avatars',
	'BOARD_CONFIG'						=> 'Configuration du forum',
	'BOARD_FUNCTIONS'					=> 'Fonctionnalités du forum',
	'PM'								=> 'Paramètres des messages privés',
	'MESSAGES'							=> 'Paramètres des messages',
	'SIGNATURES'						=> 'Paramètres de signature',
	'FEED'								=> 'Paramètres des flux',
	'USER_REGISTER'						=> 'Paramètres des enregistrements',
	'ANTI_SPAM'							=> 'Paramètres de la confirmation visuelle',
	'AUTH'								=> 'Authentification',
	'EMAIL'								=> 'Paramètres des e-mails',
	'CONFIG_JABBER'						=> 'Paramètres Jabber',
	'COOKIES'							=> 'Paramètres de cookie',
	'SERVER'							=> 'Paramètres du serveur',
	'SECURITY'							=> 'Paramètres de sécurité',
	'LOAD'								=> 'Paramètres de charge',
	'SEARCH'							=> 'Paramètres de recherche',
	'MISC'								=> 'Divers',

	'active_sessions'					=> 'Durée de la session',
	'allow_attachments'					=> 'Autoriser les fichiers joints',
	'allow_autologin'					=> 'Autoriser « Se souvenir de moi »',
	'allow_avatar'						=> 'Activer les avatars',
	'allow_avatar_gravatar'				=> 'Activer les Gravatars',
	'allow_avatar_local'				=> 'Activer la galerie d’avatars',
	'allow_avatar_remote'				=> 'Autoriser les avatars distants',
	'allow_avatar_remote_upload'		=> 'Autoriser le transfert distant d’avatars',
	'allow_avatar_upload'				=> 'Autoriser le transfert d’avatar',
	'allow_bbcode'						=> 'Autoriser les BBCodes',
	'allow_birthdays'					=> 'Autoriser les anniversaires',
	'allow_bookmarks'					=> 'Autoriser la mise en favoris des sujets',
	'allow_cdn'							=> 'Autoriser l’utilisation des CDN tiers',
	'allow_emailreuse'					=> 'Autoriser les adresses e-mail à être réutilisées',
	'allow_forum_notify'				=> 'Autoriser la surveillance des forums',
	'allow_live_searches'				=> 'Autoriser la recherche dynamique',
	'allow_mass_pm'						=> 'Autoriser l’envoi de messages privés à plusieurs utilisateurs et groupes',
	'allow_name_chars'					=> 'Longueur du nom d’utilisateur',
	'allow_namechange'					=> 'Autoriser les changements de nom d’utilisateur',
	'allow_nocensors'					=> 'Autoriser la désactivation de la censure',
	'allow_password_reset'				=> 'Autoriser la réinitialisation du mot de passe (« Mot de passe oublié »)',
	'allow_pm_attach'					=> 'Autoriser les fichiers joints dans les messages privés',
	'allow_pm_report'					=> 'Autoriser les utilisateurs à rapporter les messages privés',
	'allow_post_flash'					=> 'Autoriser l’utilisation du BBCode <code>[FLASH]</code> dans les messages',
	'allow_post_links'					=> 'Autoriser les liens dans les messages et messages privés',
	'allow_privmsg'						=> 'Messagerie privée',
	'allow_quick_reply'					=> 'Autoriser la réponse rapide',
	'allow_sig'							=> 'Autoriser les signatures',
	'allow_sig_bbcode'					=> 'Autoriser les BBCodes',
	'allow_sig_flash'					=> 'Autoriser l’utilisation du BBCode <code>[FLASH]</code> dans la signature',
	'allow_sig_img'						=> 'Autoriser l’utilisation du BBCode <code>[IMG]</code> dans la signature',
	'allow_sig_links'					=> 'Autoriser les liens dans les signatures d’utilisateurs',
	'allow_sig_pm'						=> 'Autoriser les signatures dans les messages privés',
	'allow_sig_smilies'					=> 'Autoriser les smileys dans les signatures d’utilisateurs',
	'allow_smilies'						=> 'Autoriser les smileys',
	'allow_topic_notify'				=> 'Autoriser la surveillance des sujets',
	'assets_version'					=> 'Nouveau compteur de téléchargements en CSS et Javascripts pour les actions activer / désactiver / supprimer les extensions',
	'attachment_quota'					=> 'Quota total de fichiers joints',
	'auth_bbcode_pm'					=> 'Autoriser les BBCodes dans les messages privés',
	'auth_flash_pm'						=> 'Autoriser l’utilisation du BBCode <code>[FLASH]</code>',
	'auth_img_pm'						=> 'Autoriser l’utilisation du BBCode <code>[IMG]</code>',
	'auth_method'						=> 'Sélectionner une méthode d’authentification',
	'auth_oauth_bitly_key'				=> 'Clé Bitly',
	'auth_oauth_bitly_secret'			=> 'Code secret Bitly',
	'auth_oauth_facebook_key'			=> 'Clé Facebook',
	'auth_oauth_facebook_secret'		=> 'Code secret Facebook',
	'auth_oauth_google_key'				=> 'Clé Google',
	'auth_oauth_google_secret'			=> 'Code secret Google',
	'auth_smilies_pm'					=> 'Autoriser les smileys dans les messages privés',
	'avatar_filesize'					=> 'Taille maximale d’un avatar',
	'avatar_gallery_path'				=> 'Répertoire de la galerie d’avatars',
	'avatar_max_height'					=> 'Hauteur maximale d’un avatar (en pixels)',
	'avatar_max_width'					=> 'Largeur maximale d’un avatar (en pixels)',
	'avatar_min_height'					=> 'Hauteur minimale d’un avatar (en pixels)',
	'avatar_min_width'					=> 'Largeur minimale d’un avatar (in pixels)',
	'avatar_path'						=> 'Dossier de stockage des avatars',
	'avatar_salt'						=> 'Obfusquer les noms des fichiers des avatars',
	'board_contact'						=> 'E-mail de contact',
	'board_contact_name'				=> 'Nom du contact',
	'board_disable'						=> 'Désactiver le forum',
	'board_disable_msg'					=> 'Message de désactivation du forum',
	'board_email'						=> 'Adresse e-mail de retour',
	'board_email_form'					=> 'Les utilisateurs envoient des e-mails via le forum',
	'board_email_sig'					=> 'Signature de l’e-mail',
	'board_hide_emails'					=> 'Masquer les adresses e-mails',
	'board_index_text'					=> 'Libellé de l’index du forum',
	'board_startdate'					=> 'Date d’ouverture du forum',
	'board_timezone'					=> 'Format de la date du forum',
	'browser_check'						=> 'Vérification du navigateur',
	'bump_interval'						=> 'Intervalle de remontée de sujet',
	'bump_type'							=> 'Type de l’intervalle de remontée de sujet',
	'cache_gc'							=> '',
	'cache_last_gc'						=> '',
	'captcha_gd'						=> 'GD image',
	'captcha_gd_3d_noise'				=> 'Ajouter des objets de bruit en 3D',
	'captcha_gd_fonts'					=> 'Utiliser différentes polices',
	'captcha_gd_foreground_noise'		=> 'Bruit de fond',
	'captcha_gd_wave'					=> 'Distorsion ondulatoire',
	'captcha_gd_x_grid'					=> 'Bruit de fond x-axis',
	'captcha_gd_y_grid'					=> 'Bruit de fond y-axis',
	'captcha_plugin'					=> 'Configurer les plugins',
	'check_attachment_content'			=> '',
	'check_dnsbl'						=> '',
	'chg_passforce'						=> '',
	'confirm_refresh'					=> 'Autoriser les utilisateurs à rafraîchir l’image de confirmation',
	'contact_admin_form_enable'			=> 'Activer la page de contact',
	'cookie_domain'						=> 'Domaine du cookie',
	'cookie_name'						=> 'Nom du cookie',
	'cookie_path'						=> 'Chemin du cookie',
	'cookie_secure'						=> 'Cookie sécurisé',
	'cookie_notice'						=> 'Notice d’utilisation des cookies',
	'coppa_enable'						=> 'Activer la COPPA',
	'coppa_fax'							=> 'Numéro de fax COPPA',
	'coppa_mail'						=> 'Adresse e-mail COPPA',
	'cron_lock'							=> '',
	'database_gc'						=> '',
	'database_last_gc'					=> '',
	'dbms_version'						=> 'Serveur de base de données',
	'default_lang'						=> 'Langue par défaut',
	'default_style'						=> 'Style par défaut',
	'default_dateformat'				=> 'Format de la date',
	'delete_time'						=> '',
	'display_last_edited'				=> '',
	'display_last_subject'				=> '',
	'display_order'						=> '',
	'edit_time'							=> '',
	'email_check_mx'					=> '',
	'email_enable'						=> 'Autoriser l’envoi d’e-mail via le forum',
	'email_function_name'				=> 'Nom de la fonction e-mail',
	'email_force_sender'				=> 'Forcer l’adresse courriel de réponse',
	'email_max_chunk_size'				=> '',
	'email_package_size'				=> 'Taille des paquets d’e-mails',
	'enable_confirm'					=> 'Activer la confirmation visuelle pour les enregistrements',
	'enable_mod_rewrite'				=> 'Activer la réécriture d’URL',
	'enable_pm_icons'					=> 'Autoriser les icônes de sujet dans les messages privés',
	'enable_post_confirm'				=> 'Activer la confirmation visuelle pour les visiteurs',
	'enable_update_hashes'				=> 'Activer la mise à jour du hachage',
	'extension_force_unstable'			=> 'Toujours vérifier l’existence de versions instables',
	'feed_enable'						=> 'Activer les flux',
	'feed_forum'						=> 'Activer les flux par forum',
	'feed_http_auth'					=> 'Autoriser l’authentification HTTP',
	'feed_item_statistics'				=> 'Statistiques de l’article',
	'feed_limit_post'					=> 'Nombre d’articles (messages)',
	'feed_limit_topic'					=> 'Nombre d’articles (sujets)',
	'feed_overall'						=> 'Activer les flux sur l’ensemble du forum',
	'feed_overall_forums'				=> 'Activer les flux par forum',
	'feed_topic'						=> 'Activer les flux par sujet',
	'feed_topics_active'				=> 'Activer le flux des sujets actifs',
	'feed_topics_new'					=> 'Activer le flux des nouveaux sujets',
	'flood_interval'					=> 'Intervalle de flood',
	'force_server_vars'					=> '',
	'form_token_lifetime'				=> 'Temps maximum lors de l’envoi des formulaires',
	'form_token_mintime'				=> '',
	'form_token_sid_guests'				=> 'Lier les formulaires aux sessions des invités',
	'forward_pm'						=> 'Autoriser le transfert des messages privés',
	'forwarded_for_check'				=> '',
	'full_folder_action'				=> '',
	'fulltext_mysql_max_word_len'		=> '',
	'fulltext_mysql_min_word_len'		=> '',
	'fulltext_native_common_thres'		=> '',
	'fulltext_native_load_upd'			=> '',
	'fulltext_native_max_chars'			=> '',
	'fulltext_native_min_chars'			=> '',
	'fulltext_postgres_max_word_len'	=> '',
	'fulltext_postgres_min_word_len'	=> '',
	'fulltext_postgres_ts_name'			=> '',
	'fulltext_sphinx_id'				=> 'ID Sphinx Fulltext',
	'fulltext_sphinx_data_path'			=> '',
	'fulltext_sphinx_indexer_mem_limit'	=> '',
	'fulltext_sphinx_host'				=> '',
	'fulltext_sphinx_port'				=> '',
	'fulltext_sphinx_stopwords'			=> '',
	'gzip_compress'						=> 'Activer la compression GZip',
	'help_send_statistics'				=> '',
	'help_send_statistics_time'			=> '',
	'hot_threshold'						=> '',
	'icons_path'						=> 'Emplacement des icônes de message',
	'img_create_thumbnail'				=> 'Créer une miniature',
	'img_display_inlined'				=> 'Afficher les images',
	'img_imagick'						=> 'Chemin vers ImageMagick',
	'img_link_height'					=> 'Hauteur du lien de l’image',
	'img_link_width'					=> 'Largeur du lien de l’image',
	'img_max_height'					=> 'Hauteur maximale de l’image',
	'img_max_thumb_width'				=> 'Largeur maximale de la miniature générée',
	'img_min_thumb_filesize'			=> 'Taille minimale de la miniature',
	'img_max_width'						=> 'Largeur maximale de l’image',
	'ip_check'							=> 'Nombre maximal de tentatives de connexion par nom d’utilisateur',
	'ip_login_limit_max'				=> 'Nombre maximal de tentatives de connexion par adresse IP',
	'ip_login_limit_time'				=> 'Expiration des tentatives de connexion par adresse IP',
	'ip_login_limit_use_forwarded'		=> 'Limite des tentatives de connexions par en-tête X_FORWARDED_FOR',
	'jab_enable'						=> 'Activer Jabber',
	'jab_host'							=> 'Serveur Jabber',
	'jab_package_size'					=> 'Taille des paquets Jabber',
	'jab_password'						=> 'Mot de passe Jabber',
	'jab_port'							=> 'Port Jabber',
	'jab_use_ssl'						=> 'Utiliser SSL pour se connecter',
	'jab_username'						=> 'Nom d’utilisateur Jabber ou JID',
	'jab_allow_self_signed'				=> 'Autoriser les certificats SSL auto-signés',
	'jab_verify_peer'					=> 'Verifier le certificat SSL',
	'jab_verify_peer_name'				=> 'Vérifier le nom du partenaire Jabber',
	'last_queue_run'					=> '',
	'ldap_base_dn' 						=> '',
	'ldap_email'						=> '',
	'ldap_password'						=> '',
	'ldap_port'							=> '',
	'ldap_server'						=> '',
	'ldap_uid'							=> '',
	'ldap_user'							=> '',
	'ldap_user_filter'					=> '',
	'legend_sort_groupname'				=> 'Trier la légende selon les noms de groupes',
	'limit_load'						=> '',
	'limit_search_load'					=> '',
	'load_anon_lastread'				=> '',
	'load_birthdays'					=> '',
	'load_cpf_memberlist'				=> '',
	'load_cpf_pm'						=> '',
	'load_cpf_viewprofile'				=> '',
	'load_cpf_viewtopic'				=> '',
	'load_db_lastread'					=> '',
	'load_db_track'						=> '',
	'load_jquery_url'					=> '',
	'load_jumpbox'						=> '',
	'load_moderators'					=> '',
	'load_notifications'				=> '',
	'load_online'						=> '',
	'load_online_guests'				=> '',
	'load_online_time'					=> '',
	'load_onlinetrack'					=> '',
	'load_search'						=> '',
	'load_tplcompile'					=> '',
	'load_unreads_search'				=> '',
	'load_user_activity'				=> '',
	'load_user_activity_limit'			=> '',
	'max_attachments'					=> 'Nombre maximum de fichiers joints par message',
	'max_attachments_pm'				=> 'Nombre maximum de fichiers joints par message privé',
	'max_autologin_time'				=> 'Expiration des clés de connexion « Se souvenir de moi » (en jours)',
	'max_filesize'						=> 'Taille maximale du fichier',
	'max_filesize_pm'					=> 'Taille maximale des fichiers dans la messagerie privée',
	'max_login_attempts'				=> 'Nombre maximal de tentatives de connexion par nom d’utilisateur',
	'max_name_chars'					=> 'Longueur maximale du nom d’utilisateur',
	'max_num_search_keywords'			=> 'Nombre maximum de mots clés autorisés',
	'max_pass_chars'					=> 'Longueur maximale du mot de passe',
	'max_poll_options'					=> 'Nombre maximum d’options de vote',
	'max_post_chars'					=> 'Nombre maximum de caractères par message',
	'max_post_font_size'				=> 'Taille maximale de la police',
	'max_post_img_height'				=> 'Hauteur maximale d’une image',
	'max_post_img_width'				=> 'Largeur maximale d’une image',
	'max_post_smilies'					=> 'Nombre maximum de smileys par message',
	'max_post_urls'						=> 'Nombre maximum de liens',
	'max_quote_depth'					=> 'Nombre maximum de citations imbriquées',
	'max_reg_attempts'					=> 'Tentatives d’enregistrement',
	'max_sig_chars'						=> 'Longueur maximale de la signature',
	'max_sig_font_size'					=> 'Taille maximale de la police dans les signatures',
	'max_sig_img_height'				=> 'Hauteur maximale d’une image dans les signatures',
	'max_sig_img_width'					=> 'Largeur maximale d’une image dans les signatures',
	'max_sig_smilies'					=> 'Nombre maximum de smileys par signature',
	'max_sig_urls'						=> 'Nombre maximum de liens dans les signatures',
	'mime_triggers'						=> '',
	'min_name_chars'					=> 'Longueur minimale du nom d’utilisateur',
	'min_pass_chars'					=> 'Longueur minimale du mot de passe',
	'min_post_chars'					=> 'Nombre minimum de caractères par message',
	'min_search_author_chars'			=> 'Caractères minimum du nom de l’auteur',
	'new_member_group_default'			=> 'Définir par défaut le groupe « Nouveaux utilisateurs enregistrés »',
	'new_member_post_limit'				=> 'Limite de messages d’un nouveau membre',
	'newest_user_colour'				=> 'Couleur du groupe',
	'newest_user_id'					=> 'ID de l’utilisateur enregistré le plus récent',
	'newest_username'					=> 'Nom d’utilisateur enregistré le plus récent',
	'num_files'							=> 'Nombre de fichiers joints',
	'num_posts'							=> 'Nombre de messages',
	'num_topics'						=> 'Nombre de sujets',
	'num_users'							=> 'Nombre d’utilisateurs',
	'override_user_style'				=> 'Annuler le style de l’utilisateur',
	'pass_complex'						=> 'Complexité du mot de passe',
	'plupload_last_gc'					=> '',
	'plupload_salt'						=> '',
	'pm_edit_time'						=> 'Limiter le temps de modification',
	'pm_max_boxes'						=> 'Nombre maximum de dossiers',
	'pm_max_msgs'						=> 'Nombre de messages privés maximum par dossier',
	'pm_max_recipients'					=> 'Nombre maximum autorisé de destinataires',
	'posts_per_page'					=> 'Messages par page',
	'print_pm'							=> 'Autoriser la visualisation de l’impression dans la messagerie privée',
	'questionnaire_unique_id'			=> '',
	'queue_interval'					=> '',
	'rand_seed'							=> '',
	'rand_seed_last_update'				=> '',
	'ranks_path'						=> 'Emplacement des images de rang',
	'read_notification_expire_days'		=> 'Expiration des notifications lues',
	'read_notification_gc'				=> '',
	'read_notification_last_gc'			=> '',
	'record_online_date'				=> 'Date du record des utilisateurs connectés',
	'record_online_users'				=> 'Record des utilisateurs connectés',
	'referer_validation'				=> 'Valider le référent',
	'require_activation'				=> 'Activation de compte',
	'script_path'						=> 'Chemin du script',
	'search_anonymous_interval'			=> '',
	'search_block_size'					=> '',
	'search_gc'							=> '',
	'search_indexing_state'				=> '',
	'search_interval'					=> '',
	'search_last_gc'					=> '',
	'search_store_results'				=> 'Durée de la mise en cache des résultats',
	'search_type'						=> '',
	'secure_allow_deny'					=> '',
	'secure_allow_empty_referer'		=> 'Autoriser un référent vide',
	'secure_downloads'					=> 'Activer les téléchargements sécurisés',
	'server_name'						=> 'Nom de domaine',
	'server_port'						=> 'Port du serveur',
	'server_protocol'					=> 'Protocole du serveur',
	'session_gc'						=> '',
	'session_last_gc'					=> '',
	'session_length'					=> 'Durée de la session',
	'site_desc'							=> 'Description du site',
	'site_home_text'					=> 'Libellé du site Internet',
	'site_home_url'						=> 'URL du site Internet',
	'sitename'							=> 'Nom du site',
	'smilies_path'						=> 'Emplacement des smileys',
	'smilies_per_page'					=> 'Smileys par page',
	'smtp_auth_method'					=> 'Méthode d’authentification SMTP',
	'smtp_delivery'						=> 'Utiliser un serveur SMTP pour l’envoi d’e-mails',
	'smtp_host'							=> 'Adresse du serveur SMTP',
	'smtp_password'						=> 'Mot de passe SMTP',
	'smtp_port'							=> 'Port du serveur SMTP',
	'smtp_username'						=> 'Nom d’utilisateur SMTP',
	'smtp_allow_self_signed'			=> 'Autoriser les certificats SSL auto-signés',
	'smtp_verify_peer'					=> 'Vérifier le certifcat SSL',
	'smtp_verify_peer_name'				=> 'Vérifier le nom du partenaire SMTP',
	'teampage_forums'					=> 'Forums modérés sur la page « l’équipe du forum »',
	'teampage_memberships'				=> 'Adhésions aux groupes sur la page « l’équipe du forum »',
	'topics_per_page'					=> 'Sujets par page',
	'tpl_allow_php'						=> 'Autoriser le PHP dans les templates',
	'upload_dir_size'					=> '',
	'upload_icons_path'					=> 'Emplacement des icônes de groupes d’extensions',
	'upload_path'						=> 'Répertoire de transfert',
	'update_hashes_last_cron'			=> '',
	'update_hashes_lock'				=> '',
	'use_system_cron'					=> 'Exécuter les tâches récurrentes en utilisant le « cron » système',
	'version'							=> 'Version de phpBB',
	'warnings_expire_days'				=> 'Durée de l’avertissement',
	'warnings_gc'						=> '',
	'warnings_last_gc'					=> '',
	'remote_upload_verify'				=> '',
	'allow_board_notifications' 		=> 'Activer les notifications du forum',
	'allowed_schemes_links'				=> '',
	'REPARSING'							=> 'ré-analyse',
	'reparse_lock'								=> 'Ré-analyse verrouillée',
	'text_reparser.pm_text_cron_interval'		=> 'Intervalle du cron pour ré-analyser les textes des MP',
	'text_reparser.pm_text_last_cron'			=> 'Dernière analyse lancée par le cron pour les textes des MP',
	'text_reparser.poll_option_cron_interval'	=> 'Intervalle du cron pour ré-analyser les options des sondages',
	'text_reparser.poll_option_last_cron'		=> 'Dernière analyse lancée par le cron pour les options des sondages',
	'text_reparser.poll_title_cron_interval'	=> 'Intervalle du cron pour ré-analyser les titres des sondages',
	'text_reparser.poll_title_last_cron'		=> 'Dernière analyse lancée par le cron pour les titres des sondages',
	'text_reparser.post_text_cron_interval'		=> 'Intervalle du cron pour ré-analyser les textes des messages',
	'text_reparser.post_text_last_cron'			=> 'Dernière analyse lancée par le cron pour les textes des messages',
	'text_reparser.user_signature_cron_interval'=> 'Intervalle du cron pour ré-analyser les signatures des membres',
	'text_reparser.user_signature_last_cron'	=> 'Dernière analyse lancée par le cron pour les signatures des membres',
	'UNKNOWN'							=> '<span style="color:#FF5D00"><em>Object inconnu, aucun paramètre inclus dans le standard paramétré pour phpBB 3.2.x</em></span>',
));
