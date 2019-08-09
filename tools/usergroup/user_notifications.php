<?php
/**
*
* @package Support Toolkit - User Notifycations
* @version $Id$
* @copyright (c) 2015 phpBB Group
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

class user_notifications
{
	function display_options()
	{
		global $template, $lang, $db, $request, $language, $user, $phpbb_container;

		$language->add_lang(array('ucp'));

		$phpbb_notifications = $phpbb_container->get('notification_manager');

		$period = $request->variable('period', 0);

		$submit					= $request->variable('sa', false);
		$delete					= $request->variable('del', false);
		$default_notify			= $request->variable('default_notify', 1);
		$delete_notifications	= $request->variable('delete_notifications', 0);

		$subr = $tps = array();
		$post = array(
			'notification.type.bookmark',
			'notification.type.post',
			'notification.type.topic',
			'notification.type.quote',
			'notification.type.moderation_queue',
			'moderation_queue'
		);
		$adm = array(
			'notification.type.admin_activate_user',
		);
		$mod = array(
			'notification.type.needs_approval',
			'notification.type.report',
		);
		$misc = array(
			'notification.type.group_request',
			'notification.type.pm',
		);
		$block = 'notification_types';
		$period_ary = array(0 => $lang['ALL'], 1 => $lang['7_DAYS'], 2 => $lang['1_MONTH'], 3 => $lang['3_MONTHS'], 4 => $lang['6_MONTHS'], 5 => $lang['1_YEAR']);
		$times = array(0 => 0, 1 => 7, 2 => 30, 3 => 90, 4 => 180, 5 => 365);
		$groups = array();
		$inactive_time = ($period) ? (time() - 86400 * $period) : 0;

		$s_options = '';
		foreach ($period_ary as $key => $value)
		{
			$selected = ($period == $key) ? ' selected="selected"' : '';
			$s_options .= '<option value="' . $times[$key]  . '"' . $selected . '>' . $period_ary[$key];
		}
		$s_options .= '</option>';

		$template->assign_vars(array(
			'S_PERIOD_SELECT'			=> $s_options,
			'U_DISPLAY_ACTION'			=> append_sid(STK_INDEX, array('c' => 'user_group', 't' => 'user_notifications')),
		));

		$this->output_notification_methods($phpbb_notifications, $template, $user, 'notification_methods');
		//$this->output_notification_types($phpbb_notifications, $template, $user, 'notification_types');

		$sql = 'SELECT DISTINCT item_type
			FROM ' . USER_NOTIFICATIONS_TABLE . '';
			$db->sql_query($sql);
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$tps[] = $row['item_type'];
		}
		$db->sql_freeresult($result);

		foreach ($tps as $type)
		{
			if (in_array($type, $adm))
			{
				$ad[] = array(
					'type' => $type,
					'lang' => strtoupper(str_replace('.', '_', $type)),
				);
				$subr['NOTIFICATION_GROUP_ADMINISTRATION'] = $ad;
			}
			else if (in_array($type, $post))
			{
				$options[] = array(
					'type' => $type,
					'lang' => ($type == 'moderation_queue') ? $user->lang['NOTIFICATION_TYPE_MODERATION_QUEUE'] : $user->lang[strtoupper(str_replace('.', '_', $type))],
				);
				$subr['NOTIFICATION_GROUP_POSTING'] = $options;
			}
			else if (in_array($type, $mod))
			{
				$mods[] = array(
					'type' => $type,
					'lang' => ($type == 'notification.type.needs_approval') ? $user->lang['NOTIFICATION_TYPE_IN_MODERATION_QUEUE'] : $user->lang[strtoupper(str_replace('.', '_', $type))],
				);
				$subr['NOTIFICATION_GROUP_MODERATION'] = $mods;
			}
			else if (in_array($type, $misc))
			{
				$msc[] = array(
					'type' => $type,
					'lang' => strtoupper(str_replace('.', '_', $type)),
				);
				$subr['NOTIFICATION_GROUP_MISCELLANEOUS'] = $msc;
			}
			else
			{
				$ext[] = array(
					'type' => $type,
					'lang' => strtoupper(str_replace('.', '_', $type)),
				);
				$subr['NOTIFICATION_GROUP_EXT'] = $ext;
			}
		}

		$notification_methods = $phpbb_notifications->get_subscription_methods();

		foreach ($subr as $group => $data)
		{
			$template->assign_block_vars($block, array(
				'GROUP_NAME'	=> (isset($user->lang[$group])) ? $user->lang[$group] : $lang[$group],
			));

			foreach ($data as $type => $type_data)
			{
				$template->assign_block_vars($block, array(
					'TYPE'		=> str_replace('.', '_', $type_data['type']),
					'NAME'		=> $user->lang($type_data['lang']),
				));

				foreach ($notification_methods as $method => $method_data)
				{
					$template->assign_block_vars($block . '.notification_methods', array(
						'METHOD'	=> str_replace('.', '_', $method_data['id']),
					));
				}
			}
		}

		$template->assign_vars(array(
			strtoupper($block) . '_COLS' => count($notification_methods) + 3,
		));

 		add_form_key('user_notificationd');
		if ($submit || $delete)
		{
			if (!check_form_key('user_notificationd'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}
			$sql_where = '';
			if ($inactive_time)
			{
				$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE user_regdate <= ' . $inactive_time . '
						AND user_lastvisit < ' . $inactive_time;
				$db->sql_query($sql);

				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$uids[] = $row['user_id'];
				}
				$db->sql_freeresult($result);

				if (isset($uids))
				{
					$sql_where = ' AND ' . $db->sql_in_set('user_id', $uids) . '';
				}
			}

			$user_notify_type = ($default_notify) ? 2 : 0;
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_notify = ' . $default_notify . ', user_notify_pm = ' . $default_notify. ', user_notify_type = ' . $user_notify_type . '
				WHERE user_id > 1 ' . $sql_where;
			$db->sql_query($sql);
			if (!$user_notify_type)
			{
				$sql = 'DELETE FROM phpbb_topics_watch
					WHERE user_id > 1 ' . $sql_where;
				$db->sql_query($sql);

				$sql = 'DELETE FROM phpbb_forums_watch
					WHERE user_id > 1 ' . $sql_where;
				$db->sql_query($sql);
			}

			foreach ($tps as $type)
			{
				foreach ($notification_methods as $method => $method_data)
				{
					if (!$request->is_set_post(str_replace('.', '_', $type . '_' . $method)))
					{
						$this->unset_notifications($type, $method, $sql_where, $delete_notifications);
					}
					if ($request->is_set_post(str_replace('.', '_', $type . '_' . $method)))
					{
						$this->add_notifications($type, $method, $sql_where, $delete, $delete_notifications);
					}
				}
			}
			meta_refresh(3, append_sid(STK_ROOT_PATH . 'index.' . PHP_EXT, 'c=usergroup&amp;t=user_notifications'));
			trigger_error($lang['USER_NORIFY_OK']);
		}

		$template->set_filenames(array(
			'body' => 'tools/user_notifications.html',
		));

		page_header(user_lang('USER_NOTIFICATIONS'), false);
		page_footer();
	}

	public function output_notification_methods(\phpbb\notification\manager $phpbb_notifications, \phpbb\template\template $template, \phpbb\user $user, $block = 'notification_methods')
	{
		$notification_methods = $phpbb_notifications->get_subscription_methods();

		foreach ($notification_methods as $method => $method_data)
		{
			$template->assign_block_vars($block, array(
				'METHOD'	=> $method_data['id'],
				'NAME'		=> $user->lang($method_data['lang']),
			));
		}
	}

	public function add_notifications($item_type, $method = null, $sql_where = '', $delete, $delete_notifications = 0)
	{
		global $db;

		if ($delete)
		{
			if ($delete_notifications)
			{
				$this->delete_notifications($item_type, $sql_where);
			}
			$sql = 'DELETE FROM ' . USER_NOTIFICATIONS_TABLE . "
				WHERE item_type = '" . $db->sql_escape($item_type) . "'
					AND method = '" . $db->sql_escape($method) . "'
					$sql_where";
		}
		else
		{
			$sql = 'UPDATE ' . USER_NOTIFICATIONS_TABLE . "
				SET notify = 1
				WHERE item_type = '" . $db->sql_escape($item_type) . "'
					AND method = '" . $db->sql_escape($method) . "'";
		}
		$db->sql_query($sql);
	}

	public function unset_notifications($item_type, $method = null, $sql_where = '', $delete_notifications = 0)
	{
		global $db;

		$sql = 'UPDATE ' . USER_NOTIFICATIONS_TABLE . "
			SET notify = 0
			WHERE item_type = '" . $db->sql_escape($item_type) . "'
				AND method = '" . $db->sql_escape($method) . "'
				$sql_where";
		$db->sql_query($sql);

		if ($delete_notifications)
		{
			$this->delete_notifications($item_type, $sql_where);
		}
	}

	public function delete_notifications($item_type, $sql_where)
	{
		global $db;

		$sql = 'SELECT notification_type_id
			FROM ' . NOTIFICATION_TYPES_TABLE;
		$result = $db->sql_query($sql);
		$notification_type_id = $db->sql_fetchfield('notification_type_id');
		$db->sql_freeresult($result);
		$sql = 'DELETE FROM ' . NOTIFICATIONS_TABLE  . '
			WHERE notification_type_id = ' . $notification_type_id . '' . $sql_where;
		$db->sql_query($sql);
	}
}
