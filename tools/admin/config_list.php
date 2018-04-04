<?php
/**
*
* @package Support Toolkit - Config List
* @version $Id$
* @copyright (c) 2014 Sheer
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

class config_list
{
	function display_options()
	{
		global $db, $template, $config, $lang, $cache, $phpbb_container, $request, $user;

		$start = $request->variable('start', 0);
		$limit = $request->variable('limit', $config['topics_per_page']);
		$submit = $request->variable('sa', false);
		$display = $request->variable('display', '');

		if ($submit)
		{
			$config_value = $request->variable('config', array('' => ''), true);
			$is_dinamic = $request->variable('is_dinamic', array('' => 0));

			foreach($config_value as $key => $value)
			{
				if($config[$key] != $value)
				{
					$config->set($key, $value);
				}
			}

			foreach($is_dinamic as $key => $value)
			{
				$sql = 'UPDATE '. CONFIG_TABLE .'
					SET is_dynamic = '. $value .'
					WHERE config_name = \''. $key .'\'';
				$db->sql_query($sql);
			}
			$cache->purge();

			meta_refresh(3, append_sid("" . STK_ROOT_PATH . "index." . PHP_EXT . "", 'c=admin&amp;t=config_list&amp;start=' . $start . ''));
			trigger_error(user_lang('CONFIG_CHANGED_SUCCESS'));
		}

		$options = array(
			'all'				=> $lang['ALL'],
			'statistics'		=> $lang['STATISTICS'],
			'cron'				=> $lang['CRON_TASKS'],
			'attachments'		=> $lang['ATTACHMENTS'],
			'board_config'		=> $lang['BOARD_CONFIG'],
			'board_functions'	=> $lang['BOARD_FUNCTIONS'],
			'avatars'			=> $lang['AVATARS'],
			'pm'				=> $lang['PM'],
			'messages'			=> $lang['MESSAGES'],
			'signatures'		=> $lang['SIGNATURES'],
			'feed'				=> $lang['FEED'],
			'user_register'		=> $lang['USER_REGISTER'],
			'anti_spam'			=> $lang['ANTI_SPAM'],
			'auth'				=> $lang['AUTH'],
			'email'				=> $lang['EMAIL'],
			'config_jabber'		=> $lang['CONFIG_JABBER'],
			'cookies'			=> $lang['COOKIES'],
			'server'			=> $lang['SERVER'],
			'security'			=> $lang['SECURITY'],
			'load'				=> $lang['LOAD'],
			'search'			=> $lang['SEARCH'],
			'reparsing'			=> 'REPARSING',
			'misc'				=> $lang['MISC'],
		);

		$config_cron = array(
			'cache_gc', 'cache_last_gc', 'database_gc', 'database_last_gc', 'plupload_last_gc', 'read_notification_gc', 'queue_interval', 'cron_lock',
			'read_notification_last_gc', 'search_gc', 'search_last_gc', 'session_gc', 'session_last_gc', 'warnings_gc', 'warnings_last_gc', 'update_hashes_last_cron', 'update_hashes_lock',
		);

		$config_attachments = array(
			'allow_attachments', 'allow_pm_attach', 'upload_path', 'display_order', 'attachment_quota', 'max_filesize', 'max_filesize_pm', 'max_attachments',
			'secure_downloads', 'max_attachments_pm', 'secure_allow_deny', 'secure_allow_empty_referer', 'check_attachment_content', 'img_display_inlined',
			'img_create_thumbnail', 'img_max_thumb_width', 'img_min_thumb_filesize', 'img_imagick', 'img_max', 'img_link', 'mime_triggers',
			'img_link_height', 'img_link_width', 'img_max_height', 'img_max_width',
		);

		$config_avatras = array(
			'allow_avatar', 'avatar_min_width', 'avatar_min_height', 'avatar_max_width', 'avatar_max_height', 'allow_avatar_gravatar',
			'allow_avatar_local', 'avatar_gallery_path', 'allow_avatar_remote', 'allow_avatar_upload', 'allow_avatar_remote_upload',
			'avatar_filesize', 'avatar_path', 'avatar_salt',
		);

		$config_board_config = array(
			'sitename', 'site_desc', 'site_home_url', 'site_home_text', 'board_index_text', 'board_disable', 'default_lang', 'default_dateformat',
			'board_timezone', 'default_style', 'guest_style', 'override_user_style', 'warnings_expire_days', 'board_disable_msg', 'help_send_statistics', 'help_send_statistics_time',
		);

		$config_board_functions = array(
			'allow_privmsg', 'allow_topic_notify', 'allow_forum_notify', 'allow_namechange', 'allow_attachments', 'allow_pm_attach', 'allow_pm_report', 'allow_bbcode',
			'allow_smilies', 'allow_sig', 'allow_nocensors', 'allow_bookmarks', 'allow_birthdays', 'display_last_subject', 'allow_quick_reply',
			'load_birthdays', 'load_moderators', 'load_jumpbox', 'load_cpf_memberlist', 'load_cpf_pm', 'load_cpf_viewprofile', 'load_cpf_viewtopic', 'allow_board_notifications',
		);

		$config_pm = array(
			'allow_privmsg', 'pm_max_boxes', 'pm_max_msgs', 'full_folder_action', 'pm_edit_time', 'pm_max_recipients', 'allow_mass_pm', 'auth_bbcode_pm',
			'auth_smilies_pm', 'allow_pm_attach', 'allow_sig_pm', 'print_pm', 'forward_pm', 'auth_img_pm', 'auth_flash_pm', 'enable_pm_icons',
		);

		$config_messages = array(
			'allow_topic_notify', 'allow_forum_notify', 'allow_bbcode', 'allow_post_flash', 'allow_smilies', 'allow_post_links', 'allow_nocensors', 'allow_bookmarks',
			'enable_post_confirm', 'allow_quick_reply', 'edit_time', 'delete_time', 'display_last_edited', 'flood_interval', 'bump_interval', 'bump_type',
			'topics_per_page', 'posts_per_page', 'smilies_per_page', 'hot_threshold', 'max_poll_options', 'max_post_chars', 'min_post_chars', 'max_post_smilies',
			'max_post_urls', 'max_post_font_size', 'max_quote_depth', 'max_post_img_width', 'max_post_img_height',
		);

		$config_signatures = array(
			'allow_sig', 'allow_sig_bbcode', 'allow_sig_img', 'allow_sig_flash', 'allow_sig_smilies', 'allow_sig_links', 'max_sig_chars', 'max_sig_urls',
			'max_sig_font_size', 'max_sig_smilies', 'max_sig_img_width', 'max_sig_img_height',
		);

		$config_feed = array(
			'feed_enable', 'feed_item_statistics', 'feed_http_auth', 'feed_limit_post', 'feed_overall', 'feed_forum', 'feed_topic', 'feed_limit_topic',
			'feed_topics_new', 'feed_topics_active', 'feed_news_id', 'feed_overall_forums',
		);

		$config_user_register = array(
			'require_activation', 'new_member_post_limit', 'new_member_group_default', 'min_name_chars', 'min_pass_chars', 'allow_name_chars', 'pass_complex',
			'chg_passforce', 'allow_namechange', 'allow_emailreuse', 'enable_confirm', 'max_login_attempts', 'max_reg_attempts', 'coppa_enable',
			'coppa_mail', 'coppa_fax', 'max_name_chars', 'max_pass_chars',
		);

		$config_anti_spam = array(
			'enable_confirm', 'max_reg_attempts', 'max_login_attempts', 'enable_post_confirm', 'confirm_refresh', 'captcha_gd', 'captcha_gd_foreground_noise',
			'captcha_gd_x_grid', 'captcha_gd_y_grid', 'captcha_gd_wave', 'captcha_gd_3d_noise', 'captcha_gd_fonts', 'captcha_plugin',
		);

		$config_contact_admin = array(
			'contact_admin_form_enable',
		);

		$config_auth = array(
			'auth_method', 'ldap_server', 'ldap_port', 'ldap_dn', 'ldap_uid', 'ldap_user_filter', 'ldap_email', 'ldap_user', 'ldap_password',
			'auth_oauth_bitly_key', 'auth_oauth_bitly_secret', 'auth_oauth_facebook_key', 'auth_oauth_facebook_secret', 'auth_oauth_google_key', 'auth_oauth_google_secret'
		);

		$config_email = array(
			'email_enable', 'board_email_form', 'email_function_name', 'email_package_size', 'board_contact', 'board_contact_name', 'board_email', 'board_email_sig',
			'board_hide_emails', 'smtp_delivery', 'smtp_host', 'smtp_port', 'smtp_auth_method', 'smtp_username', 'email_max_chunk_size', 'smtp_password', 'email_force_sender', 'smtp_allow_self_signed', 'smtp_verify_peer', 'smtp_verify_peer_name',
		);

		$config_config_jabber = array(
			'jab_enable', 'jab_host', 'jab_port', 'jab_username', 'jab_password', 'jab_package_size', 'jab_use_ssl', 'jab_allow_self_signed', 'jab_verify_peer', 'jab_verify_peer_name'
		);

		$config_cookies = array(
			'cookie_domain', 'cookie_name', 'cookie_path', 'cookie_secure', 'cookie_notice',
		);

		$config_server = array(
			'gzip_compress', 'use_system_cron', 'enable_mod_rewrite', 'smilies_path', 'icons_path', 'upload_icons_path', 'ranks_path',
			'force_server_vars', 'server_protocol', 'server_name', 'server_port', 'script_path',
		);

		$config_security = array(
			'allow_autologin', 'allow_password_reset', 'max_autologin_time', 'ip_check', 'browser_check', 'forwarded_for_check', 'referer_validation', 'check_dnsbl',
			'email_check_mx', 'min_pass_chars', 'pass_complex', 'chg_passforce', 'max_login_attempts', 'ip_login_limit_max', 'ip_login_limit_time',
			'ip_login_limit_use_forwarded', 'tpl_allow_php', 'form_token_lifetime', 'form_token_sid_guests', 'remote_upload_verify',
		);

		$config_load = array(
			'limit_load', 'session_length', 'active_sessions', 'load_online_time', 'read_notification_expire_days', 'load_notifications', 'load_db_track',
			'load_db_lastread', 'load_anon_lastread', 'load_online', 'load_online_guests', 'load_onlinetrack', 'load_birthdays', 'load_unreads_search',
			'load_moderators', 'load_jumpbox', 'load_user_activity', 'load_tplcompile', 'allow_cdn', 'allow_live_searches', 'load_cpf_memberlist',
			'load_cpf_pm', 'load_cpf_viewprofile', 'load_cpf_viewtopic', 'load_user_activity_limit', 'enable_accurate_pm_button',
		);

		$config_search = array(
			'load_search', 'search_interval', 'search_anonymous_interval', 'limit_search_load', 'min_search_author_chars', 'max_num_search_keywords',
			'search_store_results', 'search_type', 'search_block_size', 'fulltext_mysql_max_word_len', 'fulltext_mysql_min_word_len', 'fulltext_native_load_upd',
			'search_fulltext_mysql_settings', 'fulltext_native_min_chars', 'fulltext_native_max_chars', 'fulltext_native_common_thres',
			'fulltext_postgres_ts_name', 'fulltext_postgres_max_word_len', 'fulltext_postgres_min_word_len', 'fulltext_postgres_ts_name',
			'fulltext_sphinx_id', 'fulltext_sphinx_data_path', 'fulltext_sphinx_indexer_mem_limit', 'fulltext_sphinx_host', 'fulltext_sphinx_port', 'fulltext_sphinx_stopwords',
		);

		$config_statistics = array(
			'dbms_version', 'last_queue_run', 'board_startdate', 'newest_user_id', 'newest_username', 'num_files', 'num_posts', 'num_topics',
			'num_users', 'record_online_date', 'record_online_users', 'upload_dir_size', 'version',
		);

		$config_reparsing = array(
			'reparse_lock', 'text_reparser.pm_text_cron_interval', 'text_reparser.pm_text_last_cron', 'text_reparser.poll_option_cron_interval',
			'text_reparser.poll_option_last_cron', 'text_reparser.poll_title_cron_interval', 'text_reparser.poll_title_last_cron',
			'text_reparser.post_text_cron_interval', 'text_reparser.post_text_last_cron', 'text_reparser.user_signature_cron_interval',
			'text_reparser.user_signature_last_cron',
		);

		$config_common = $config_all = array();
		$config_common = array_merge($config_common, $config_statistics);
		$config_common = array_merge($config_common, $config_cron);
		$config_common = array_merge($config_common, $config_attachments);
		$config_common = array_merge($config_common, $config_avatras);
		$config_common = array_merge($config_common, $config_board_config);
		$config_common = array_merge($config_common, $config_board_functions);
		$config_common = array_merge($config_common, $config_pm);
		$config_common = array_merge($config_common, $config_messages);
		$config_common = array_merge($config_common, $config_signatures);
		$config_common = array_merge($config_common, $config_feed);
		$config_common = array_merge($config_common, $config_user_register);
		$config_common = array_merge($config_common, $config_anti_spam);
		$config_common = array_merge($config_common, $config_auth);
		$config_common = array_merge($config_common, $config_email);
		$config_common = array_merge($config_common, $config_config_jabber);
		$config_common = array_merge($config_common, $config_cookies);
		$config_common = array_merge($config_common, $config_server);
		$config_common = array_merge($config_common, $config_security);
		$config_common = array_merge($config_common, $config_load);
		$config_common = array_merge($config_common, $config_search);
		$config_common = array_merge($config_common, $config_reparsing);

		$sql = 'SELECT *
			FROM ' . CONFIG_TABLE. '
			ORDER BY config_name ASC';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$config_all[] = $row['config_name'];
		}
		$db->sql_freeresult($result);

		$config_misc = array_diff($config_all, $config_common);

		foreach ($options as $option => $lang_key)
		{
			$template->assign_block_vars('options', array(
				'OPTION'	=> $option,
				'LANG'		=> isset($lang[$lang_key]) ? $lang[$lang_key] : $lang_key,
				'SELECTED'	=> ($display == $option) ? true : false,
			));
		}

		$sql_where = $where = '';
		if ($display == 'all' || !$display)
		{
			// Show all
			$sql_where = '';
		}
		else
		{
			// Show selected
			switch ($display)
			{
				case 'statistics'		:
					$where = $config_statistics;
				break;
				case 'cron'				:
					$where = $config_cron;
				break;
				case 'attachments'		:
					$where = $config_attachments;
				break;
				case 'avatars'			:
					$where = $config_avatras;
				break;
				case 'board_config'		:
					$where = $config_board_config;
				break;
				case 'board_functions'	:
					$where = $config_board_functions;
				break;
				case 'pm'				:
					$where = $config_pm;
				break;
				case 'messages'			:
					$where = $config_messages;
				break;
				case 'signatures'		:
					$where = $config_signatures;
				break;
				case 'feed'				:
					$where = $config_feed;
				break;
				case 'user_register'	:
					$where = $config_user_register;
				break;
				case 'anti_spam'		:
					$where = $config_anti_spam;
				break;
				case 'auth'				:
					$where = $config_auth;
				break;
				case 'email'			:
					$where = $config_email;
				break;
				case 'config_jabber'	:
					$where = $config_config_jabber;
				break;
				case 'cookies'			:
					$where = $config_cookies;
				break;
				case 'server'			:
					$where = $config_server;
				break;
				case 'security'			:
					$where = $config_security;
				break;
				case 'load'				:
					$where = $config_load;
				break;
				case 'search'		:
					$where = $config_search;
				break;
				case 'reparsing'	:
					$where = $config_reparsing;
				break;
				case 'misc'		:
					$where = $config_misc;
				break;
				default:
				break;
			}
			$sql_where = ' WHERE ' . $db->sql_in_set('config_name', $where) . '';
		}

		page_header(user_lang('CONFIG_LIST'));

		$sql = 'SELECT COUNT(config_name) as count
				FROM ' . CONFIG_TABLE . '
				' . $sql_where ;
		$result = $db->sql_query($sql);
		$count = $db->sql_fetchfield('count');
		$db->sql_freeresult($result);

		$sql = 'SELECT *
			FROM ' . CONFIG_TABLE . '
			' . $sql_where . '
			ORDER BY config_name ASC';
		$result = $db->sql_query_limit($sql, $limit, $start);

		$not_bool = array('assets_version', 'form_token_mintime', 'img_link_height', 'img_link_width', 'img_max_height', 'img_max_width', 'max_attachments_pm', 'max_autologin_time', 'max_post_img_height',
			'max_post_img_width', 'max_post_smilies', 'max_post_urls', 'max_sig_img_height', 'max_sig_img_width', 'max_sig_smilies', 'num_files', 'default_style', 'cron_lock', 'upload_dir_size',
			'num_posts', 'num_topics', 'num_users', 'pm_edit_time', 'pm_max_recipients', 'search_interval', 'search_anonymous_interval', 'search_indexing_state', 'plupload_last_gc', 'warnings_expire_days',
			'last_queue_run', 'text_reparser.user_signature_last_cron', 'update_hashes_last_cron'
		);
		$ex_time_gc = array('database_gc', 'cache_gc', 'session_gc', 'search_gc', 'warnings_gc', 'read_notification_gc');

		$human_date = array(
			'board_startdate',
			'text_reparser.pm_text_last_cron', 'text_reparser.poll_option_last_cron', 'text_reparser.poll_title_last_cron',
			'text_reparser.post_text_last_cron', 'text_reparser.user_signature_last_cron', 'update_hashes_last_cron'
		);

		while ($row = $db->sql_fetchrow($result))
		{
			$is_bool = false;
			// Value is numeric?
			if (!in_array($row['config_name'], $not_bool) && is_numeric($row['config_value']) || $row['config_name'] == 'enable_confirm')
			{
				// Value is boolean?
				if ($row['config_value'] == 0 || $row['config_value'] == 1)
				{
					$is_bool = true;
					// If value not set imagine it equal NULL
					if (!isset($row['config_value']))
					{
						$row['config_value'] = NULL;
					}
				}
			}

			$template->assign_block_vars('row', array(
				'CONFIG_PURPOSE'		=> (isset($lang[$row['config_name']])) ? $lang[$row['config_name']] : $lang['UNKNOWN'],
				'CONFIG_NAME'			=> $row['config_name'],
				'CONFIG_VALUE'			=> $row['config_value'],
				'IS_DINAMIC'			=> $row['is_dynamic'],
				'IS_DINAMIC_CHECKED'	=> ($row['is_dynamic']) ? 'checked="checked"' : '',
				'S_CHECKED'				=> ($row['config_value'] && $is_bool) ? 'checked="checked"' : '',
				'S_NO_CHECKED'			=> (!$row['config_value'] && $is_bool) ? 'checked="checked"' : '',
				'NO_DINAMIC_CHECKED'	=> (!$row['is_dynamic']) ? 'checked="checked"' : '',
				'S_BOOL'				=> ($is_bool) ? true : false,
				'HUMAN_DATE'			=> (!in_array($row['config_name'], $ex_time_gc) && ((substr($row['config_name'], -3, 3) === '_gc') || $row['config_name'] === 'last_queue_run' || $row['config_name'] === 'rand_seed_last_update') || $row['config_name'] == 'record_online_date' || $row['config_name'] == 'help_send_statistics_time' || (in_array($row['config_name'], $human_date))) ? $user->format_date($row['config_value'], '|d M Y|, H:i:s'): ''
			));
		}
		$db->sql_freeresult($result);

		// Build Pagination URL
		$pagination = $phpbb_container->get('pagination');
		$base_url = append_sid(STK_INDEX, 't=config_list&amp;go=1&amp;limit=' . $limit . '&amp;display=' . $display . '');
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $count, $limit, $start);

		$template->assign_vars(array(
			'L_CONFIG_LIST'			=> $lang['CONFIG_LIST'],
			'L_CONFIG_LIST_EXPLAIN'	=> $lang['CONFIG_LIST_EXPLAIN'],
			'L_LIMIT'				=> $lang['LIMIT'],
			'L_FILTER'				=> $lang['FILTER'],
			'L_TOTAL_ITEMS'			=> $lang['TOTAL_ITEMS'],
			'L_CLICK_HERE_TO_CHANGE'=> $lang['CLICK_HERE_TO_CHANGE'],

			'TOTAL_ITEMS'		=> $count,
			'LIMIT'				=> $limit,
			'A_BASE_URL'		=> append_sid(STK_INDEX, array('c' => 'admin', 't' => 'config_list', 'limit' => '' . $limit . '&amp;display=' . $display . '', 'go' => 1)),
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, 't=config_list&amp;go=1'),
			'S_ACTION'			=> append_sid("" . STK_ROOT_PATH . "index." . PHP_EXT . "", 'c=admin&amp;t=config_list&amp;start=' . $start . '&amp;limit=' . $limit . '&amp;display=' . $display . ''),
		));

		$template->set_filenames(array(
			'body' => 'tools/config_list.html',
		));

		page_footer();
	}
}
