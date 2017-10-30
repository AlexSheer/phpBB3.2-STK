<?php
/**
*
* @package Support Toolkit - Set prosilver as default style
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

class set_prosilver
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		return 'SET_PROSILVER';
	}

	/**
	* Run Tool
	*
	* Does the actual stuff we want the tool to do after submission
	*/
	function run_tool()
	{
		global $db, $request, $config, $lang;

		if (!file_exists(PHPBB_ROOT_PATH . 'styles/prosilver/style.cfg'))
		{
			trigger_error($lang['SET_PROSILVER_DOES_NOT_EXIST'], E_USER_WARNING);
		}

		$sql = 'SELECT style_id, style_active
			FROM ' . STYLES_TABLE . "
			WHERE style_name = 'prosilver'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$style_id = $row['style_id'];
		$style_active = $row['style_active'];
		$default_style = $config['default_style'];

		if (!$style_id)
		{
			$sql_ary = array(
				'style_name'			=> 'prosilver',
				'style_copyright'		=> '&copy; phpBB Group',
				'style_active'			=> 1,
				'style_path'			=> 'prosilver',
				'bbcode_bitfield'		=> 'lNg=',
				'style_parent_id'		=> '0',
				'style_parent_tree'		=> '',
			);
			$sql = 'INSERT INTO ' . STYLES_TABLE . '
				' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql);
			$id = $db->sql_nextid();
			$config->set('default_style', $id);
			$config->set('guest_style', $id);
			$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_style = ' . $id);

			trigger_error($lang['SET_PROSILVER_RESET']);
		}

		if ($style_id == $config['default_style'])
		{
			if (!$style_active)
			{
				$db->sql_query('UPDATE ' . STYLES_TABLE . ' SET style_active = 1 WHERE style_id = ' . $style_id . '');
				trigger_error($lang['SET_PROSILVER_ACTIVATED']);
			}
			trigger_error($lang['SET_PROSILVER_ALLREADY_ASSIGNED']);
		}
		else
		{
			$db->sql_query('UPDATE ' . STYLES_TABLE . ' SET style_active = 1 WHERE style_id = ' . $style_id . '');
			$config->set('default_style', $style_id);
			$config->set('guest_style', $style_id);
			trigger_error($lang['SET_PROSILVER_RESET']);
		}
	}
}

