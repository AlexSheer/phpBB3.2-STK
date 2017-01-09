<?php
/**
*
* @package Support Toolkit - Update email hashes
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

class update_email_hashes
{
	/**
	* Batch size of the ammount email addresses we'll change per run
	*/
	var $batch_size = 500;

	/**
	* Display Options
	*/
	function display_options()
	{
		if (@phpversion() < '7.0.0')
		{
			return 'UPDATE_EMAIL_HASHES';
		}

		global $lang;

		if (confirm_box(true))
		{
			$this->run_tool();
		}
		else
		{
			confirm_box(false, user_lang('UPDATE_EMAIL_HASHES_CONFIRM'), '', 'confirm_body.html', STK_DIR_NAME . '/index.' . PHP_EXT . '?c=support&amp;t=update_email_hashes&amp;submit=' . true);
		}
	}

	/**
	* Run the tool
	*/
	function run_tool()
	{
		global $db, $template, $request, $lang;

		$step = $request->variable('step', 0);

		// Select the batch
		$sql = 'SELECT user_id, user_email, user_email_hash
			FROM ' . USERS_TABLE;
		$result	= $db->sql_query_limit($sql, $this->batch_size, ($step * $this->batch_size));
		$batch	= $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		if (!$batch)
		{
			trigger_error($lang['UPDATE_EMAIL_HASHES_COMPLETE']);
		}

		foreach ($batch as $userrow)
		{
			$new_hash = $this->do_hash($userrow['user_email']);
			if ($userrow['user_email_hash'] == $new_hash)
			{
				// Skip if the hash hasn't changed
				continue;
			}

			// Update the field
			$sql = 'UPDATE ' . USERS_TABLE . " SET user_email_hash = '" . $new_hash . "'
				WHERE user_id = " . $userrow['user_id'];
			$db->sql_query($sql);
		}

		meta_refresh(0, append_sid(STK_INDEX, array('c' => 'support', 't' => 'update_email_hashes', 'submit' => true, 'step' => ++$step)));
		$template->assign_var('U_BACK_TOOL', false);

		trigger_error($lang['UPDATE_EMAIL_HASHES_NOT_COMPLETE']);
	}

	/**
	* Hashes an email address to a big integer (phpbb_email_hash)
	*
	* @param string $email		Email address
	*
	* @return string			Unsigned Big Integer
	*/
	function do_hash($email)
	{
		return sprintf('%u', crc32(strtolower($email))) . strlen($email);
	}
}
