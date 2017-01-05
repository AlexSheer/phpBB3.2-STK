<?php
/**
*
* @package Support Toolkit - Orphaned posts/topics
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

class orphaned_posts
{
	function display_options()
	{
		global $db, $template, $user, $phpbb_root_path, $phpEx;

		//
		// Orphaned topics
		//
		$sql = ' SELECT topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour
			FROM ' . TOPICS_TABLE . ' t
			WHERE NOT EXISTS (SELECT forum_id FROM ' . FORUMS_TABLE . ' WHERE forum_id = t.forum_id)';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('orphaned_topics', array(
				'FORUM_ID'		=> $row['forum_id'],
				'U_FORUM'		=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']),
				'TOPIC_ID'		=> $row['topic_id'],
				'TOPIC_TITLE'	=> $row['topic_title'],
				'USER_FULL'		=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'USER_ID'		=> $row['topic_poster'],
			));
		}
		$db->sql_freeresult($result);

		//
		// Empty topics
		//
		$sql = 'SELECT t.topic_id
			FROM ' . TOPICS_TABLE . ' t
			LEFT JOIN ' . POSTS_TABLE . ' p ON (p.topic_id = t.topic_id)
			WHERE t.topic_moved_id = 0
			GROUP BY t.topic_id
			HAVING COUNT(p.post_id) = 0';
		$result = $db->sql_query($sql);

		$topic_ids = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$topic_ids[] = (int) $row['topic_id'];
		}
		$db->sql_freeresult($result);

		if (sizeof($topic_ids))
		{
			// Fetch information related to the topics
			$sql = 'SELECT t.topic_id, t.topic_title, t.topic_poster, t.forum_id, f.forum_name, u.user_id, u.username, u.user_colour
				FROM ' . TOPICS_TABLE . ' t
				JOIN ' . USERS_TABLE . ' u ON (u.user_id = topic_poster)
				JOIN ' . FORUMS_TABLE . ' f ON (f.forum_id = t.forum_id)
				WHERE ' . $db->sql_in_set('t.topic_id', $topic_ids);
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$template->assign_block_vars('topics', array(
					'FORUM_ID'		=> $row['forum_id'],
					'FORUM_NAME'	=> $row['forum_name'],
					'U_FORUM'		=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']),
					'TOPIC_ID'		=> $row['topic_id'],
					'TOPIC_TITLE'	=> $row['topic_title'],
					'USER_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
					'USER_ID'		=> $row['user_id'],
				));
			}
			$db->sql_freeresult($result);
		}

		//
		// Orphaned posts
		//
		$sql = 'SELECT post_id, post_time, post_username, post_subject, post_text, bbcode_uid, bbcode_bitfield, p.forum_id, f.forum_name, u.user_id, u.username, u.user_colour
			FROM ' . POSTS_TABLE . ' p
			JOIN ' . USERS_TABLE . ' u ON (u.user_id = p.poster_id)
			JOIN ' . FORUMS_TABLE . ' f ON (f.forum_id = p.forum_id)
			WHERE NOT EXISTS (SELECT topic_id FROM ' . TOPICS_TABLE . ' WHERE topic_id = p.topic_id)';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$message = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], OPTION_FLAG_BBCODE | OPTION_FLAG_SMILIES);
			$search_keywords = urlencode((strpos($row['post_subject'], 'Re: ') === 0) ? utf8_substr($row['post_subject'], 4) : $row['post_subject']);

			$template->assign_block_vars('posts', array(
				'FORUM_ID'		=> $row['forum_id'],
				'FORUM_NAME'	=> $row['forum_name'],
				'U_FORUM'		=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']),
				'POST_ID'		=> $row['post_id'],
				'POST_SUBJECT'	=> $row['post_subject'],
				'POST_TEXT'		=> $message,
				'SEARCH_URL'	=> append_sid("{$phpbb_root_path}search.$phpEx", 'keywords=' . $search_keywords . '&amp;terms=all&amp;sf=titleonly&amp;sr=topics&amp;submit=Search', true),
				'USER_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'USER_ID'		=> $row['user_id'],
			));
		}
		$db->sql_freeresult($result);


		$sql = 'SELECT post_id, post_time, post_username, post_subject, post_text, bbcode_uid, bbcode_bitfield, p.forum_id, u.user_id, u.username, u.user_colour
			FROM ' . POSTS_TABLE . ' p
			JOIN ' . USERS_TABLE . ' u ON (u.user_id = p.poster_id)
			WHERE  NOT EXISTS (SELECT forum_id FROM ' . FORUMS_TABLE . ' WHERE forum_id = p.forum_id)';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$message = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], OPTION_FLAG_BBCODE | OPTION_FLAG_SMILIES);
			$search_keywords = urlencode((strpos($row['post_subject'], 'Re: ') === 0) ? utf8_substr($row['post_subject'], 4) : $row['post_subject']);
			$template->assign_block_vars('emptyforumposts', array(
				'FORUM_ID'		=> $row['forum_id'],
				'FORUM_NAME'	=> '',
				//'U_FORUM'		=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']),
				'POST_ID'		=> $row['post_id'],
				'POST_SUBJECT'	=> $row['post_subject'],
				'POST_TEXT'		=> $message,
				'SEARCH_URL'	=> append_sid("{$phpbb_root_path}search.$phpEx", 'keywords=' . $search_keywords . '&amp;terms=all&amp;sf=titleonly&amp;sr=topics&amp;submit=Search', true),
				'USER_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'USER_ID'		=> $row['user_id'],
			));
		}
		$db->sql_freeresult($result);

		//
		// Orphaned shadow topics
		//
		$sql = 'SELECT t.topic_id, t.topic_moved_id, t.topic_title, t.topic_poster, t.forum_id, f.forum_name, u.user_id, u.username, u.user_colour
			FROM ' . TOPICS_TABLE . ' t
			JOIN ' . USERS_TABLE . ' u ON (u.user_id = t.topic_poster)
			JOIN ' . FORUMS_TABLE . ' f ON (f.forum_id = t.forum_id)
			WHERE topic_moved_id <> 0
				AND NOT EXISTS (SELECT topic_id FROM ' . TOPICS_TABLE . ' WHERE topic_id = t.topic_moved_id)';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('shadows', array(
				'FORUM_ID'		=> $row['forum_id'],
				'FORUM_NAME'	=> $row['forum_name'],
				'U_FORUM'		=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']),
				'TOPIC_ID'		=> $row['topic_id'],
				'TOPIC_TITLE'	=> $row['topic_title'],
				'USER_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'USER_ID'		=> $row['user_id'],
			));
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'U_EMPTY_TOPICS'			=> append_sid(STK_INDEX, array('c' => 'support', 't' => 'orphaned_posts', 'mode' => 'empty_topics')),
			'U_ORPHANED_POSTS'			=> append_sid(STK_INDEX, array('c' => 'support', 't' => 'orphaned_posts', 'mode' => 'orphaned_posts', 'submit' => 1)),
			'U_ORPHANED_SHADOWS'		=> append_sid(STK_INDEX, array('c' => 'support', 't' => 'orphaned_posts', 'mode' => 'orphaned_shadows')),
			'U_FORUM_ORPHANED_POSTS'	=> append_sid(STK_INDEX, array('c' => 'support', 't' => 'orphaned_posts', 'mode' => 'forum_orphaned_posts', 'submit' => 1)),
			'U_FORUM_ORPHANED_TOPICS'	=> append_sid(STK_INDEX, array('c' => 'support', 't' => 'orphaned_posts', 'mode' => 'forum_orphaned_topics', 'submit' => 1)),
		));

		$template->set_filenames(array(
			'body' => 'tools/orphaned_posts.html',
		));

		page_header(user_lang('ORPHANED_POSTS'), false);
		page_footer();
	}

	/**
	* Perform the right actions
	* @param Array $error An array that will be filled with error messages that might occure
	* @return void
	*/
	function run_tool(&$error)
	{
		global $db, $lang, $user, $request;

		$user->add_lang('ucp');

		if (!check_form_key('orphaned_posts'))
		{
			$error[] = 'FORM_INVALID';
			return;
		}

		$mode = $request->variable('mode', '');
		switch ($mode)
		{
			case 'empty_topics':
			case 'orphaned_shadows':
			case 'forum_orphaned_topics':
				if (isset($_POST['reassign']) && $mode == 'forum_orphaned_topics')
				{					$forums_map = $request->variable('forum', array(0 => 0));
					foreach ($forums_map as $topic_id => $forum_id)
					{
						if ($forum_id == 0)
						{
							unset($forums_map[$topic_id]);
						}
					}
					if (!sizeof($forums_map))
					{
						trigger_error($lang['NO_FORUMS_IDS'], E_USER_WARNING);
					}
					// Make sure the specified forums IDs exist
					$forum_ids = array_values($forums_map);
					$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . ' WHERE ' . $db->sql_in_set('forum_id', $forum_ids);
					$result = $db->sql_query($sql);
					$existing_forums = array();
					while ($row = $db->sql_fetchrow($result))
					{
						$existing_forums[] = (int) $row['forum_id'];
					}
					$db->sql_freeresult($result);

					$missing_forums = array_diff($forum_ids, $existing_forums);
					if (sizeof($missing_forums))
					{
						trigger_error(sprintf($lang['NONEXISTENT_FORUMS_IDS'], implode(', ', $missing_forums)), E_USER_WARNING);
					}

					foreach ($forums_map as $topic_id => $forum_id)
					{
						$sql = 'UPDATE ' . TOPICS_TABLE . ' SET forum_id = ' . $forum_id . ' WHERE topic_id = ' . $topic_id;
						$db->sql_query($sql);
					}
					sinc_stats();
					trigger_error(sprintf($lang['TOPICS_REASSIGNED'], sizeof($forums_map)));
				}
				else
				{
					$topic_ids = $request->variable('topics', array(0 => 0));
					if (!sizeof($topic_ids))
					{
						trigger_error($lang['NO_TOPICS_SELECTED'], E_USER_WARNING);
					}

					if (!function_exists('delete_topics'))
					{
						include($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
					}

					$return = delete_topics('topic_id', $topic_ids);
					trigger_error(user_lang('TOPICS_DELETED', $return['topics']));
				}
			break;

			case 'forum_orphaned_posts':
			// No break
			case 'orphaned_posts':
				if (isset($_POST['reassign']))
				{
					$post_map = $request->variable('posts', array(0 => 0));

					foreach ($post_map as $post_id => $topic_id)
					{
						if ($topic_id == 0)
						{
							unset($post_map[$post_id]);
						}
					}

					if (!sizeof($post_map))
					{
						trigger_error($lang['NO_TOPIC_IDS'], E_USER_WARNING);
					}

					// Make sure the specified topic IDs exist
					$topic_ids = array_values($post_map);
					$sql = 'SELECT topic_id, forum_id FROM ' . TOPICS_TABLE . ' WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
					$result = $db->sql_query($sql);

					$existing_topics = array();
					while ($row = $db->sql_fetchrow($result))
					{
						$existing_topics[] = (int) $row['topic_id'];
					}
					$db->sql_freeresult($result);

					$missing_topics = array_diff($topic_ids, $existing_topics);
					if (sizeof($missing_topics))
					{
						trigger_error(sprintf($lang['NONEXISTENT_TOPIC_IDS'], implode(', ', $missing_topics)), E_USER_WARNING);
					}
					// Update the topics with their new IDs
					foreach ($post_map as $post_id => $topic_id)
					{
						$sql = 'SELECT forum_id FROM ' . TOPICS_TABLE . ' WHERE topic_id = ' . (int) $topic_id . '';
						$result = $db->sql_query_limit($sql, 1);
						$forum_id = (int) $db->sql_fetchfield('forum_id');
						$db->sql_freeresult($result);
						$sql = 'UPDATE ' . POSTS_TABLE . ' SET topic_id = ' . (int) $topic_id . ', forum_id = ' . (int) $forum_id . ' WHERE post_id = ' . (int) $post_id;
						$db->sql_query($sql);
					}

					sinc_stats();
					trigger_error(sprintf($lang['POSTS_REASSIGNED'], sizeof($post_map)));
				}
				else if (isset($_POST['delete']))
				{
					$post_ids = $request->variable('posts_del', array(0 => 0));

					if (!sizeof($post_ids))
					{
						trigger_error($lang['NO_POSTS_SELECTED'], E_USER_WARNING);
					}

					if (!function_exists('delete_posts'))
					{
						include($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
					}

					$return = delete_posts('post_id', $post_ids);
					sinc_stats();
					trigger_error(sprintf($lang['POSTS_DELETED'], $return));
				}
				else
				{
					trigger_error($lang['NO_MODE'], E_USER_WARNING);
				}
			break;

			default:
				trigger_error($lang['NO_MODE'], E_USER_WARNING);
			break;
		}
	}
}
