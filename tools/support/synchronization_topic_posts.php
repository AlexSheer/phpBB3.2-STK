<?php
/**
*
* @package Support Toolkit - Synchronization topics/posts
* @version $Id$
* @copyright (c) 2016 Alg http://www.phpbbguru.net/community/memberlist.php?mode=viewprofile&u=41189
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

class synchronization_topic_posts
{
	function display_options()
	{
		global $db, $template, $lang, $phpbb_root_path, $phpEx;

		// Not synchronized topics
		$sql = 'SELECT t.forum_id, topic_id, topic_title, topic_last_post_id, topic_last_poster_id, topic_last_poster_name, topic_last_post_time,
			topic_last_view_time, topic_posts_approved, topic_posts_unapproved, topic_posts_softdeleted, f.forum_name,
			(SELECT COUNT(post_id) FROM ' . POSTS_TABLE . ' p WHERE p.topic_id = t.topic_id) AS post_count,
			(SELECT MAX(post_id) FROM ' . POSTS_TABLE . ' p WHERE p.topic_id = t.topic_id) AS max_post_id
				FROM ' . TOPICS_TABLE  . ' t
				JOIN ' . FORUMS_TABLE . ' f ON f.forum_id = t.forum_id
			WHERE t.topic_moved_id = 0
			AND (topic_posts_approved + topic_posts_unapproved + topic_posts_softdeleted) <> (SELECT COUNT(post_id) FROM ' . POSTS_TABLE . ' WHERE topic_id = t.topic_id)
			ORDER BY t.topic_id DESC';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$topic_total_posts = (int) $row['topic_posts_approved'] + (int) $row['topic_posts_unapproved'] + (int) $row['topic_posts_softdeleted'];
			$topic_total_posts .= ' (' . $row['topic_posts_approved'] . '+' .  $row['topic_posts_unapproved'] . '+' . $row['topic_posts_softdeleted'] . ')';
			$template->assign_block_vars('topics_not_synchronized', array(
				'FORUM_ID'				=> $row['forum_id'],
				'U_TOPIC'				=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", 't=' . $row['topic_id']),
				'TOPIC_ID'				=> $row['topic_id'],
				'TOPIC_TITLE'			=> $row['topic_title'] . '(' . $row['forum_name'] . ')',
				'TOPIC_TOTAL_POSTS'		=> $topic_total_posts,
				'REAL_TOTAL_POSTS'		=> $row['post_count'],
				'TOPIC_LAST_POST_ID'	=> $row['topic_last_post_id'],
				'MAX_POST_ID'			=> $row['max_post_id'],
            ));
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'L_TOPIC_TOTAL_POSTS'				=> sprintf($lang['TOPIC_TOTAL_POSTS'], TOPICS_TABLE),
			'L_POSTS_TOTAL_CAPTION'				=> sprintf($lang['POSTS_TOTAL'], POSTS_TABLE),
			'L_FROM_TOPICS_TABLE'				=> sprintf($lang['FROM_TABLE'], TOPICS_TABLE),
			'L_FROM_POSTS_TABLE'				=> sprintf($lang['FROM_TABLE'], POSTS_TABLE),
			'U_SYNCHRONIZATION_TOPIC_POSTS'		=> append_sid(STK_INDEX, array('c' => 'support', 't' => 'synchronization_topic_posts', 'submit' => 1)),
		));

		$template->set_filenames(array(
			'body' => 'tools/synchronization_topic_posts.html',
		));

		page_header($lang['SYNCHRONIZATION_TOPIC_POSTS'], false);
		page_footer();
	}

	/**
	* Perform the right actions
	* @param Array $error An array that will be filled with error messages that might occure
	* @return void
	*/
	function run_tool(&$error)
	{
		global $db, $lang;

		if (!check_form_key('synchronization_topic_posts'))
		{
			$error[] = 'FORM_INVALID';
			return;
		}
		$topic_ids = request_var('topics', array(0 => 0));
		if (!sizeof($topic_ids))
		{
			trigger_error($lang['NO_TOPICS_SELECTED'], E_USER_WARNING);
		}
		foreach($topic_ids as $topic_id)
		{
			$sql = 'SELECT post_id, topic_id, post_time, poster_id, post_username, post_subject, post_visibility, post_delete_time, username, user_colour, user_posts,
			(SELECT COUNT(post_id) FROM ' . POSTS_TABLE . ' WHERE poster_id = u.user_id) AS really_user_posts,
			(SELECT COUNT(post_id) FROM ' . POSTS_TABLE . ' WHERE topic_id = p.topic_id AND post_visibility = 1) AS really_posts_approved,
			(SELECT COUNT(post_id) FROM ' . POSTS_TABLE . ' WHERE topic_id = p.topic_id AND post_visibility = 0 AND post_delete_time = 0) AS really_posts_unapproved,
			(SELECT COUNT(post_id) FROM ' . POSTS_TABLE . ' WHERE topic_id = p.topic_id AND post_delete_time<>0) AS really_posts_softdeleted
				FROM ' . POSTS_TABLE . ' p  JOIN ' . USERS_TABLE . ' u ON p.poster_id = u.user_id
					WHERE topic_id=' . (int)  $topic_id . '
					ORDER BY post_id DESC';
			$result = $db -> sql_query_limit($sql, 1);
			$post_data = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			if($post_data)
			{
				//Update topics
				$upd_ary = array(
					'topic_last_post_id'		=> $post_data['post_id'],
					'topic_last_poster_id'		=> $post_data['poster_id'],
					'topic_last_poster_name'	=> $post_data['username'],
					'topic_last_poster_colour'	=> $post_data['user_colour'],
					'topic_last_post_subject'	=> $post_data['post_subject'],
					'topic_last_post_time'		=> $post_data['post_time'],
					'topic_posts_approved'		=> $post_data['really_posts_approved'],
					'topic_posts_unapproved'	=> $post_data['really_posts_unapproved'],
					'topic_posts_softdeleted'	=> $post_data['really_posts_softdeleted'],
				);

				$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET ' . $db->sql_build_array('UPDATE', $upd_ary) . "
					WHERE topic_id = $topic_id";
					$db->sql_query($sql);
				//update poster statistic(if it needs)
				if($post_data['user_posts'] != $post_data['really_user_posts'])
				{
					$sql = 'UPDATE ' . USERS_TABLE  . ' SET user_posts=' . $post_data['really_user_posts'] . ' WHERE user_id = ' . $post_data['poster_id'];
					$db->sql_query($sql);
	 			}
		    }
		}
		meta_refresh(3, append_sid(STK_INDEX, array('c' => 'support', 't' => 'synchronization_topic_posts')));
		trigger_error(sprintf($lang['TOPICS_SINCRONIZED'], sizeof($topic_ids)));
	}
}
