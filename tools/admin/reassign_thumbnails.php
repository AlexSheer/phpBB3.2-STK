<?php
/**
 *
 * @package Support Toolkit - Reassign Thumbnails
 * @copyright (c) 2017 phpBBGuru Sheer
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

/**
 * Make sure that all attachments files on the database
 */
class reassign_thumbnails
{
	/**
	 * The number of files tested per run
	 * @var Integer
	 */
	var $_batch_size = 50;

	/**
	 * Options
	 * @return String
	 */
	function display_options()
	{
		return 'REASSIGN_THUMBNAILS';
	}

	function run_tool()
	{
		global $config, $db, $lang, $cache, $template, $phpEx;

		include_once(PHPBB_ROOT_PATH . 'includes/functions_posting.' . $phpEx);
		ignore_user_abort(true);
		set_time_limit(0);

		$step			= request_var('step', 0);

		$begin			= $this->_batch_size * $step;
		$upload_path	= PHPBB_ROOT_PATH . $config['upload_path'] . '/';

		$total = $cache->get('_stk_reassign_thumbnails'); // Try get data from cache

		if (!$total)
		{
			$total = $this->count_total_images();
			$cache->put('_stk_reassign_thumbnails', $total);
		}
		if (!$total)
		{
			// Nothing to do
			$cache->destroy('_stk_reassign_thumbnails');
			trigger_error($lang['NO_THUMBNAILS_TO_REBUILD'], E_USER_WARNING);
		}

		$list = sprintf($lang['NEED_TO_PROCESS'], $total) . '<br />';

		// Get the batch
		$batch = $this->get_images($begin, $this->_batch_size);
		$thumbs = $cache->get('_stk_thumbnails'); // Try get data from cache

		for ($i = 0; $i < count($batch); $i++)
		{
			$source_file = $upload_path . $batch[$i]['physical_filename'];
			//Generate Thumbnail Filename
			$thumb_file_name = 'thumb_' . $batch[$i]['physical_filename'];
			//Make Sure The File Actually Exists Before Processing It
			if (file_exists($upload_path . $batch[$i]['physical_filename']))
			{
				if (create_thumbnail($upload_path . $batch[$i]['physical_filename'], $upload_path . $thumb_file_name, $batch[$i]['mimetype']))
				{
					$output[] = $lang['REBUILT'] . $batch[$i]['physical_filename'] . ' ' . $lang['THUMB'] . ' '. $thumb_file_name;
					$thumbs[] = $batch[$i]['attach_id'];
				}
				else
				{
					$output[] = $lang['NO_NEED_REBUILT'] . $batch[$i]['physical_filename'];
				}
			}
			else
			{
				$output[] = $lang['SOURCE_UNAVAILABLE'] . $batch[$i]['physical_filename'];
			}
		}

		if (empty($batch))
		{
			// Nothing to do
			$cache->destroy('_stk_reassign_thumbnails');
			$thumbs = $cache->get('_stk_thumbnails');
			$cache->destroy('_stk_thumbnails');
			if (!empty($thumbs))
			{
				$db->sql_query('UPDATE ' . ATTACHMENTS_TABLE . ' SET thumbnail = 1 WHERE ' . $db->sql_in_set('attach_id', $thumbs));
			}
			trigger_error($lang['REASSIGN_THUMBNAILS_FINISHED']);
		}

		// Next step
		if (!isset($thumbs))
		{
			$thumbs = array();
		}
		$cache->put('_stk_thumbnails', $thumbs);
		$template->assign_var('U_BACK_TOOL', false);
		meta_refresh(3, append_sid(STK_INDEX, array('c' => 'admin', 't' => 'reassign_thumbnails', 'step' => ++$step, 'submit' => true)));
		trigger_error('' . $lang['REASSIGN_THUMBNAILS_PROGRESS'] . '<br />' . $list . implode("<br />", $output) . '');
	}

	function count_total_images()
	{
		global $db, $config, $lang;

		$extensions = array();

		$sql = 'SELECT group_id
			FROM ' . EXTENSION_GROUPS_TABLE . '
			WHERE group_name = \'IMAGES\'';
		$result = $db->sql_query($sql);
		$group_id = (int) $db->sql_fetchfield('group_id');
		$db->sql_freeresult($result);

		if (!$group_id)
		{
			$sql = 'SELECT group_id
				FROM ' . EXTENSION_GROUPS_TABLE . '
				WHERE group_name = \'' . $lang['IMAGES'] . '\'';
			$result = $db->sql_query($sql);
			$group_id = (int) $db->sql_fetchfield('group_id');
			$db->sql_freeresult($result);
			if (!$group_id)
			{
				trigger_error($lang['NO_EXTENSIONS_GROUP'], E_USER_WARNING);
			}
		}

		$sql = 'SELECT extension
			FROM ' . EXTENSIONS_TABLE . '
			WHERE group_id = ' . $group_id;
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$extensions[] = $row['extension'];
		}
		$db->sql_freeresult($result);

		if (!$extensions)
		{
			trigger_error($lang['NO_EXTENSIONS'], E_USER_WARNING);
		}

		$sql_where = '';
		foreach($extensions as $extension)
		{
			$sql_where .= 'extension = \'' . $extension . '\' OR ';
		}

		$sql_where = substr($sql_where, 0, -4);

		$sql = 'SELECT COUNT(attach_id) AS total
			FROM ' . ATTACHMENTS_TABLE . '
			 WHERE thumbnail = 0 AND filesize > ' . $config['img_min_thumb_filesize'] . ' AND (' . $sql_where . ')';
		$result = $db->sql_query($sql);
		$total = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);
		return $total;
	}

	function get_images($start = 0 , $limit = 20)
	{
		global $config, $db, $lang;

		$data = array();

		$sql = 'SELECT group_id
			FROM ' . EXTENSION_GROUPS_TABLE . '
			WHERE group_name = \'IMAGES\'';
		$result = $db->sql_query($sql);
		$group_id = (int) $db->sql_fetchfield('group_id');
		$db->sql_freeresult($result);
		if (!$group_id)
		{
			$sql = 'SELECT group_id
				FROM ' . EXTENSION_GROUPS_TABLE . '
				WHERE group_name = \'' . $lang['IMAGES'] . '\'';
			$result = $db->sql_query($sql);
			$group_id = (int) $db->sql_fetchfield('group_id');
			$db->sql_freeresult($result);
			if (!$group_id)
			{
				trigger_error($lang['NO_EXTENSIONS_GROUP'], E_USER_WARNING);
			}
		}

		$sql = 'SELECT extension
			FROM ' . EXTENSIONS_TABLE . '
			WHERE group_id = ' . $group_id;
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$extensions[] = $row['extension'];
		}
		$db->sql_freeresult($result);

		$sql_where = '';
		foreach($extensions as $extension)
		{
			$sql_where .= 'extension = \'' . $extension . '\' OR ';
		}

		$sql_where = substr($sql_where, 0, -4);

		$sql = 'SELECT attach_id, physical_filename, mimetype
			FROM ' . ATTACHMENTS_TABLE . '
			 WHERE thumbnail = 0 AND filesize > ' . $config['img_min_thumb_filesize'] . ' AND (' . $sql_where . ')';

		$result = $db->sql_query_limit($sql, $limit, $start);
		while ($row = $db->sql_fetchrow($result))
		{
			$data[] = $row;
		}
		$db->sql_freeresult($result);

		return $data;
	}
}
