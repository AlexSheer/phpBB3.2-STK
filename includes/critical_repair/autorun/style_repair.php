<?php
/**
*
* @package Support Toolkit
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

class erk_style_repair
{
	function run()
	{
		global $config, $db;

		$config['default_style'] = (!isset($config['default_style']) || !$config['default_style']) ? 1 : $config['default_style'];

		$sql = 'SELECT style_id, style_path
			FROM ' . STYLES_TABLE . '
			WHERE style_id = ' . (int) $config['default_style'];

		$result = $db->sql_query($sql);
		// No styles in the database
		$data = $db->sql_fetchrow($result);
		if (empty($data))
		{
			// Styles appear to be broken.  Attempt automatic repair
			$this->repair();
		}
		$db->sql_freeresult($result);
		return true;
	}

	function repair()
	{
		global $db, $table_prefix;

		$sql = 'SELECT style_id
			FROM ' . STYLES_TABLE;
		$result2 = $db->sql_query_limit($sql, 1);
		$row = $db->sql_fetchrow($result2);
		if ($row)
		{
			// There is a style in the database, so we are lucky
			set_config('default_style', $row['style_id']);
		}

		$db->sql_freeresult($result2);
	}
}
