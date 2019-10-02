<?php
/**
*
* @package Support Toolkit - Reparse BBCode
* @version $Id$
* @copyright (c) 2009 phpBB Group
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

define('RUN_HTMLSPECIALCHARS_DECODE', false);

/**
* @note: the backup feature currently only crates a backup of the posts that are
* 		 being reparsed. There is not yet an interface to restore it!
*/
class delete_bbcode
{
	/**
	* The message parser object
	*/
	var $message_parser = null;

	/**
	* The poll parser object
	*/
	var $poll_parser = null;

	/**
	* Contains the entry that is currently being reparsed
	*/
	var $data = array();

	/**
	 * The total number of posts when the "reparseall" flag is set
	 * @var integer
	 */
	var $max = 0;

	/**
	* BBCode options
	*/
	var $flags = array(
		'enable_bbcode'		=> false,
		'enable_magic_url'	=> false,
		'enable_smilies'	=> false,
		'img_status'		=> false,
		'flash_status'		=> false,
		'enable_urls'		=> false,
	);

	var $bbcodes = array('youtube', 'video', 'audio');

	/**
	* Number of posts to be parsed per run
	*/
	var $step_size = 150;

	/**
	* The name of the table that we use to backup posts before running
	* this tool
	*/
	var $_backup_table_name = 'stk_reparse_bbcode_backup';

	/**
	* The schema of the backup table
	*/
	var $_backup_table_schema = array(
		'COLUMNS'		=> array(
			'post_id'			=> array('UINT', 0),
			'forum_id'			=> array('UINT', 0),
			'post_subject'		=> array('VCHAR', ''),
			'post_subject'		=> array('STEXT_UNI', '', 'true_sort'),
			'post_text'			=> array('MTEXT_UNI', ''),
			'post_checksum'		=> array('VCHAR:32', ''),
			'bbcode_bitfield'	=> array('VCHAR:255', ''),
			'bbcode_uid'		=> array('VCHAR:8', ''),
		),
		'KEYS'			=> array(
			'post_id'			=> array('INDEX', 'post_id'),
			'forum_id'			=> array('INDEX', 'forum_id'),
		),
	);

	/**
	* Tool overview page
	*/
	function display_options()
	{
		return array(
			'title'	=> 'DELETE_BBCODE',
			'vars'	=> array(
				'legend1'			=> 'DELETE_BBCODE',
				'create_backup'		=> array('lang' => 'CREATE_BACKUP_TABLE', 'validate' => 'bool',	'type' => 'radio:yes_no', 'explain' => true),
				'reparseids'		=> array('lang'	=> 'DELETE_BBCODE_POST_IDS', 'type' => 'textarea:3:255', 'explain' => 'true'),
				'reparseforums'		=> array('lang' => 'DELETE_BBCODE_FORUMS', 'explain' => true, 'type' => 'select_multiple', 'function' => 'get_forums'),
				'bbcode_select'		=> array('lang' => 'DELETE_BBCODE_SELECT', 'explain' => true, 'type' => 'select', 'function' => 'get_bbcodes'),
				'reparseall'		=> array('lang' => 'DELETE_BBCODE_ALL', 'type' => 'checkbox', 'explain' => true),
			),
		);
	}

	/**
	* Run the tool
	*/
	function run_tool()
	{
		global $cache, $config, $db, $request, $language, $lang;
		// Prevent some errors from missing language strings.
		$language->add_lang(array('posting'));

		// Define some vars that we'll need
		$last_batch			= false;
		$reparse_id 		= $request->variable('reparseids', '');
		$reparse_forum_ids	= $request->variable('reparseforums', array(0));
		$create_backup 		= $request->variable('create_backup', false);
		$all 				= $request->variable('reparseall', false);
		$step				= $request->variable('step', 0);
		$start				= $step * $this->step_size;
		$cnt				= 0;
		$bbcode				= $request->variable('bbcode_select', '');

		if (!sizeof($reparse_forum_ids) && !$reparse_id && !$all && $step == 0)
		{
			trigger_error(user_lang('IDS_EMPTY'), E_USER_WARNING);
		}

		// If post IDs were specified, we need to make sure the list is valid.
		$reparse_posts = array();

		if ($reparse_forum_ids)
		{
			$reparse_id = '';

			$sql = 'SELECT post_id
				FROM ' . POSTS_TABLE . '
					WHERE ' . $db->sql_in_set('forum_id', $reparse_forum_ids) . '
					AND post_text '. $db->sql_like_expression(str_replace('*', $db->get_any_char(), '*' . $this->bbcodes[$bbcode] . '*')) . '';
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow())
			{
				$reparse_id .= $row['post_id'] . ',';
			}
			$db->sql_freeresult($result);
		}

		if (!empty($reparse_id))
		{
			$reparse_posts = explode(',', $reparse_id);
			$reparse_forum_ids = array();

			if (!sizeof($reparse_posts))
			{
				trigger_error(user_lang('REPARSE_IDS_INVALID'), E_USER_WARNING);
			}

			// Make sure there's no extra whitespace
			array_walk($reparse_posts, array($this, '_trim_post_ids'));

			$cache->put('_stk_reparse_posts', $reparse_posts);
		}
		else
		{
			if (($result = $cache->get('_stk_reparse_posts')) !== false)
			{
				$reparse_posts = $result;
			}
		}

		// The message parser
		if (!class_exists('parse_message'))
		{
			global $phpbb_root_path, $phpEx; // required!
			include PHPBB_ROOT_PATH . 'includes/message_parser.' . PHP_EXT;
		}

		// Posting helper functions
		if (!function_exists('submit_post'))
		{
			include PHPBB_ROOT_PATH . 'includes/functions_posting.' . PHP_EXT;
		}

		// First step? Prepare the backup
		if ($create_backup && $step == 0)
		{
			$this->_prepare_backup();
		}

		// Greb our batch
		// First the easiest, the user selected certain posts
		if (!empty($reparse_posts))
		{
			$this->step_size = sizeof($reparse_posts);

			// This is always done in one go
			$last_batch = true;
		}
		else
		{
			// Get the total
			$this->max = $request->variable('rowsmax', 0);
			if ($this->max == 0)
			{
				$sql = 'SELECT COUNT(post_id) AS cnt
					FROM ' . POSTS_TABLE . '
					WHERE post_text '. $db->sql_like_expression(str_replace('*', $db->get_any_char(), '*' . $this->bbcodes[$bbcode] . '*')) . '';
				$result		= $db->sql_query($sql);
				$max = $this->max	= $db->sql_fetchfield('cnt', false, $result);
				$db->sql_freeresult($result);
			}

			// Change step_size if needed
			if ($start + $this->step_size > $this->max)
			{
				$this->step_size = $this->max - $start;

				// Make sure that the loop is finished
				$last_batch = true;
			}
		}

		if (sizeof($reparse_posts))
		{
			$sql_where = ' AND ' . $db->sql_in_set('post_id', $reparse_posts);
		}
		else
		{
			$sql_where = '';
		}

		$sql_ary = array(
			'SELECT'	=> 'f.forum_id, f.enable_indexing, f.forum_name,
							p.post_id, p.poster_id, p.icon_id, p.post_text, p.post_subject, p.post_username, p.post_time, p.post_edit_reason, p.bbcode_uid, p.bbcode_bitfield, p.post_checksum, p.enable_sig, p.post_edit_locked, p.enable_bbcode, p.enable_magic_url, p.enable_smilies, p.post_attachment, p.post_edit_user,
							t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_type, t.topic_status, t.topic_title, t.poll_title, t.topic_time_limit, t.poll_start, t.poll_length, t.poll_max_options, t.poll_last_vote, t.poll_vote_change, t.topic_posts_approved, t.topic_posts_unapproved, t.topic_posts_softdeleted,
							u.username',
			'FROM'		=> array(
				FORUMS_TABLE	=> 'f',
				POSTS_TABLE		=> 'p',
				TOPICS_TABLE	=> 't',
				USERS_TABLE		=> 'u',
			),
			'WHERE'		=> 'p.post_text '. $db->sql_like_expression(str_replace('*', $db->get_any_char(), '*' . $this->bbcodes[$bbcode] . '*')) . ' AND t.topic_id = p.topic_id AND u.user_id = p.poster_id AND f.forum_id = t.forum_id' . $sql_where . '',
		);
		$sql	= $db->sql_build_query('SELECT', $sql_ary);
		$result	= $db->sql_query_limit($sql, $this->step_size, $start);
		$batch	= $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		// Backup
		if ($create_backup)
		{
			$this->_backup($batch);
		}

		// Walk through the batch
		foreach ($batch as $this->data)
		{
			// Update the post flags
			$this->flags['enable_bbcode']		= ($config['allow_bbcode']) ? $this->data['enable_bbcode'] : false;
			$this->flags['enable_magic_url']	= ($config['allow_post_links']) ? $this->data['enable_magic_url'] : false;
			$this->flags['enable_smilies']		= ($this->data['enable_smilies']) ? true : false;
			$this->flags['img_status']			= ($config['allow_bbcode']) ? true : false;
			$this->flags['flash_status']		= ($config['allow_bbcode'] && $config['allow_post_flash']) ? true : false;
			$this->flags['enable_urls']			= ($config['allow_post_links']) ? true : false;

			$post_data = array();
			$this->message_parser = new parse_message($this->data['post_text']);
			unset($this->data['post_text']);

			// Reparse the post

			$this->_reparse_post($post_data, $bbcode);

			// Set post_username
			// post_username is either empty or contains guest username.
			// If empty post username and if p.poster_id is not ANONYMOUS, use u.username else leave as it is.
			// Bug #62889
			$username = '';
			if ($this->data['poster_id'] == ANONYMOUS)
			{
				$username = !empty($this->data['post_username']) ? trim($this->data['post_username']) : '';
			}
			else
			{
				$username = $this->data['username'];
			}

			// Re-submit the post through API
			submit_post('edit', $this->data['post_subject'], $username, $this->data['topic_type'], $this->poll, $post_data, true, true);
		}

		// Finished?
		if ($last_batch)
		{
			// Done!
			$cache->destroy('_stk_reparse_posts');
			trigger_error($lang['DELETE_BBCODE_COMPLETE']);
		}

		// Next step
		$this->_next_step($step);
	}

	function _reparse_post(&$post_data, $bbcode)
	{
		global $db, $user;

		// Some default variables that must be set
		static $uninit = array();
		if (empty($uninit))
		{
			$uninit = array(
				'post_attachment'	=> 0,
				'poster_id'			=> $user->data['user_id'],
				'enable_magic_url'	=> 0,
				'topic_status'		=> 0,
				'topic_type'		=> POST_NORMAL,
				'post_subject'		=> '',
				'topic_title'		=> '',
				'post_time'			=> 0,
				'post_edit_reason'	=> '',
				'notify'			=> 0,
				'notify_set'		=> 0,
			);
		}

		// Clean it
		$this->_clean_message($this->message_parser, $bbcode);

		// Attachments?
		if ($this->data['post_attachment'] == 1)
		{
			// Fetch the attachments for this post
			$sql = 'SELECT attach_id, is_orphan, attach_comment, real_filename
				FROM ' . ATTACHMENTS_TABLE . '
				WHERE post_msg_id = ' . (int) $this->data['post_id'] . '
					AND in_message = 0
					AND is_orphan = 0
				ORDER BY filetime DESC';
			$result = $db->sql_query($sql);
			$this->message_parser->attachment_data = $db->sql_fetchrowset($result);
			$db->sql_freeresult($result);
		}

		// Post has a poll?
		if ($this->data['poll_title'] && $this->data['post_id'] == $this->data['topic_first_post_id'])
		{
			$this->_reparse_poll();
		}

		// Re-parse it
		$this->message_parser->parse($this->flags['enable_bbcode'], $this->flags['enable_magic_url'], $this->flags['enable_smilies'], $this->flags['img_status'], $this->flags['flash_status'], true, $this->flags['enable_urls']);

		// Consider the bbcode_bitfield required for the poll
		if (!empty($this->poll_parser) && !empty($this->poll_parser->bbcode_bitfield))
		{
			$this->message_parser->bbcode_bitfield = base64_encode(base64_decode($this->poll_parser->bbcode_bitfield) | base64_decode($this->message_parser->bbcode_bitfield));
		}

		// Update the post data
		$post_data = array_merge($this->data, $this->flags, array(
			'bbcode_bitfield'	=> $this->message_parser->bbcode_bitfield,
			'bbcode_uid'		=> $this->message_parser->bbcode_uid,
			'message'			=> $this->message_parser->message,
			'message_md5'		=> md5($this->message_parser->message),
			'attachment_data'	=> $this->message_parser->attachment_data,
			'filename_data'		=> $this->message_parser->filename_data,
		));

		// Need to adjust topic_time_limit here. Per bug #61155
		$post_data['topic_time_limit'] = $post_data['topic_time_limit']/86400;

		// Make sure this data is set
		foreach ($uninit as $var_name => $default_value)
		{
			if (!isset($post_data[$var_name]))
			{
				$post_data[$var_name] = $default_value;
			}
		}
		unset($uninit);
	}

	/**
	* This method will return the given message into its state as it would have
	* been just *after* $request->variable.
	* It expects the parse_message object related to this post but the object
	* should only be filled, no changes should be made before this call
	* @param Object &$parser the parser object
	*/
	function _clean_message(&$parser, $bbcode)
	{
		global $request;

		$pattern = array('[' . $this->bbcodes[$bbcode] . ']', '[/' . $this->bbcodes[$bbcode] . ']');

		$find = array(
			'|\[' . $this->bbcodes[$bbcode] . '\](.*?)\[/' . $this->bbcodes[$bbcode] . '\]|s',
			'|\[' . $this->bbcodes[$bbcode] . '=(.*?)\](.*?)\[/' . $this->bbcodes[$bbcode] . '\]|s',
		);

		$replace = array(
			'$1',
			'$1',
		);

		// Format the content as if it where *INSIDE* the posting field.
		$parser->decode_message($this->data['bbcode_uid']);
		$message = &$parser->message;	// tmp copy
		if (defined('RUN_HTMLSPECIALCHARS_DECODE') && RUN_HTMLSPECIALCHARS_DECODE == true)
		{
			$message = htmlspecialchars_decode($message);
		}
		$text = html_entity_decode_utf8($message);
		$message = preg_replace($find, $replace, $text);

		// Now we'll *$request->variable* the post
		set_var($message, $message, 'string', true);
		$message = utf8_normalize_nfc($message);

		// Update the parser
		$parser->message = &$message;
		unset($message);
	}

	/**
	* Move the tool to the next step
	* @param Integer $step The current step
	* @param Integer $mode The current reparse mode
	* @param Boolean $next_mode Move to the next reparse type
	*/
	function _next_step($step)
	{
		global $template, $request;

		$all = $request->variable('reparseall', false);
		$create_backup = $request->variable('create_backup', false);

		$_next_step	= ++$step;
		$_rowsmax	= $this->max;

		// Create the redirect params
		$params = array(
			'c'			=> 'admin',
			't'			=> 'delete_bbcode',
			'rowsmax'	=> $_rowsmax,
			'submit'	=> true,
			'step'		=> $_next_step,
			'reparseall'	=> ($all) ? true : false,
			'create_backup'	=> ($create_backup) ? true : false,
		);

		meta_refresh(1, append_sid(STK_ROOT_PATH . 'index.' . PHP_EXT, $params));
		$template->assign_var('U_BACK_TOOL', false);

		trigger_error('' . user_lang('DELETE_BBCODES') . '<br />' . user_lang('DELETE_BBCODE_PROGRESS', ($this->step_size), $this->max) . '');
	}

	function _trim_post_ids(&$post_id, $key)
	{
		// This is difficult, no?
		$post_id = (int) trim($post_id);
	}

	/**
	* Make sure that the backup table exists *AND* is empty
	*/
	function _prepare_backup()
	{
		global $db, $umil;

		// Table doesn't exists?
		if ($umil->table_exists($this->_backup_table_name) === false)
		{
			// Create it
			$umil->table_add($this->_backup_table_name, $this->_backup_table_schema);
		}

		// Empty the table
		$db->sql_query('DELETE FROM ' . $this->_backup_table_name);
	}

	/**
	* Backup the given post
	* @param Array $batch Batch of posts we are re-parsing this round
	*/
	function _backup($batch)
	{
		global $db;

		// Prepare data
		$data = array();

		foreach ($batch as $post)
		{
			$data[] = array(
				'post_id'			=> $post['post_id'],
				'forum_id'			=> $post['forum_id'],
				'post_subject'		=> $post['post_subject'],
				'post_text'			=> $post['post_text'],
				'post_checksum'		=> $post['post_checksum'],
				'bbcode_bitfield'	=> $post['bbcode_bitfield'],
				'bbcode_uid'		=> $post['bbcode_uid'],
			);
		}

		$db->sql_multi_insert($this->_backup_table_name, $data);
	}
}

function get_bbcodes()
{
	$bbcodes = array('youtube', 'video', 'audio');
	$s_bbcodes = '';
	$i = 0;
	foreach ($bbcodes as $bbcode)
	{
		$s_bbcodes .= '<option value="'. $i++ .'">' . $bbcode . '</option>';
	}

	return $s_bbcodes;
}
