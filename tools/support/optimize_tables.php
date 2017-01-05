<?php
/**
*
* @package Support Toolkit - DB Tables optimizer
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

class optimize_tables
{
	function display_options()
	{
		global $user, $template, $db, $request;

		$submit = $request->variable('sa', false);
		$tables = $request->variable('tables_list', array(''));

		$table_cout = $fragmented = 0;
		$action = append_sid(STK_ROOT_PATH . 'index.' . PHP_EXT, 'c=suppor&amp;t=optimize_tables');

		if ($submit)
		{
			if (!empty($tables))
			{
				for($i = 0; $i < count($tables); $i++)
				{
					$fil = $tables[$i];
					$sql = 'OPTIMIZE TABLE '.$tables[$i].'';
					$db->sql_query($sql);
				}
				$message = user_lang('SUCESS');
			}
			else
			{
				$message =  $user->lang['NOTHING'];
			}
			meta_refresh(3, $action);
			trigger_error($message);
		}
		else
		{
			$sql = 'SHOW TABLE STATUS
				WHERE Data_free > 0';
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result))
			{
				if(($row['Engine'] != 'InnoDB'))
				{
					$table_cout++;
					$fragmented = $fragmented + $row['Data_free'];
					$template->assign_block_vars('row', array(
						'TABLE_NAME'	=> $row['Name'],
						'TABLE_SIZE'	=> $row['Data_length'],
						'FRAGMENTED'	=> $row['Data_free'],
						'CREATE_TIME'	=> $row['Create_time'],
						'UPDATE_TIME'	=> $row['Update_time'],
						'CHECK_TIME'	=> $row['Check_time'],
					));
				}
			}
			$db->sql_freeresult($result);

			$template->assign_vars(array(
				'TABLES'				=> $table_cout,
				'FRAGMENTED'			=> $fragmented,
				'U_DISPLAY_ACTION'		=> $action,

				'L_OPTIMIZE_TABLES'			=> user_lang('OPTIMIZE_TABLES'),
				'L_OPTIMIZE_TABLES_EXPLAIN'	=> user_lang('OPTIMIZE_TABLES_EXPLAIN'),
				'L_NOT_FOUND'				=> user_lang('NOT_FOUND'),
				'L_TABLE_NAME'				=> user_lang('TABLE_NAME'),
				'L_UPDATE_TIME'				=> user_lang('UPDATE_TIME'),
				'L_TABLE_SIZE'				=> user_lang('TABLE_SIZE'),
				'L_FRAGMENTED'				=> user_lang('FRAGMENTED'),
				'L_OPTIMIZER_MESSAGE'		=> user_lang('OPTIMIZER_MESSAGE'),
				)
			);
		}

		// This is kinda like the main page
		// Output the main page
		page_header(user_lang('SUPPORT_TOOL_KIT'));

		$template->set_filenames(array(
			'body' => 'tools/db_optimizer.html',
		));

		page_footer();
	}
}
