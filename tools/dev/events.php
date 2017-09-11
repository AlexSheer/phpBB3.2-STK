<?php
/**
*
* @package Support Toolkit - Events
* @version $Id$
* @copyright (c) 2010 phpBB Group
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

class events
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		global $template, $phpbb_root_path;

		// This is kinda like the main page
		// Output the main page
		page_header(user_lang('SUPPORT_TOOL_KIT'));

		$template->assign_vars(array(
			'PATH'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'phpbb')),
		));

		$template->set_filenames(array(
			'body' => 'tools/events_body.html',
		));

		page_footer();
	}
}
