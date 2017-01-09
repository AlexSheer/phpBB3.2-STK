<?php
/**
*
* @package Support Toolkit - Purge Cache
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

class purge_cache
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		if (@phpversion() < '7.0.0')
		{
			return 'PURGE_CACHE';
		}

		global $lang;

		if (confirm_box(true))
		{
			$this->run_tool();
		}
		else
		{
			confirm_box(false, user_lang('PURGE_CACHE_CONFIRM'), '', 'confirm_body.html', STK_DIR_NAME . '/index.' . PHP_EXT . '?c=admin&amp;t=purge_cache&amp;submit=' . true);
		}
	}

	/**
	* Run Tool
	*
	* Does the actual stuff we want the tool to do after submission
	*/
	function run_tool(&$error)
	{
		global $auth, $cache;

		$cache->purge();

		// Clear permissions
		$auth->acl_clear_prefetch();
		cache_moderators();

		add_log('admin', 'LOG_PURGE_CACHE');

		trigger_error(user_lang('PURGE_CACHE_COMPLETE'));
	}
}
