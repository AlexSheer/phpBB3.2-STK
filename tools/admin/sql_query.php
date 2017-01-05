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

class sql_query
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		return array(
			'title'	=> 'SQL_QUERY',
			'vars'	=> array(
				'legend1'			=> 'SQL_QUERY_LEGEND',
				'sql_query'			=> array('lang' => 'SQL_QUERY', 'type' => 'textarea:20:255', 'explain' => true),
				'show_results'		=> array('lang' => 'SHOW_RESULTS', 'type' => 'checkbox', 'explain' => true),
			)
		);
	}

	/**
	* Run Tool
	*
	* Does the actual stuff we want the tool to do after submission
	*/
	function run_tool(&$error)
	{
		global $cache, $db, $dbms, $table_prefix, $template, $request, $phpbb_root_path;

		if (!check_form_key('sql_query'))
		{
			$error[] = 'FORM_INVALID';
			return;
		}

		$show_results = $request->variable('show_results', false);
		$sql_query = utf8_normalize_nfc($request->variable('sql_query', '', true));
		$sql_query = htmlspecialchars_decode($sql_query);	// Need special chars like < and > see bug #59755

		// Replace phpbb_ with the correct table prefix.  Do the double replace otherwise you can have issues with prefixes like phpbb_3
		$sql_query = str_replace('phpbb_', $table_prefix, str_replace($table_prefix, 'phpbb_', $sql_query));

		if (!$sql_query)
		{
			$error[] = 'NO_SQL_QUERY';
			return;
		}

		$fs = new phpbb\filesystem\filesystem();
		$database = new phpbb\install\helper\database($fs, $phpbb_root_path);

		$dbms=  str_replace('phpbb\\db\\driver\\', '', $dbms);
		$dbmd = $database->get_available_dbms($dbms);

		$delimiter = $dbmd[$dbms]['DELIM'];
		$database->remove_comments($sql_query);
		$sql_query = $database->split_sql_file($sql_query, $delimiter);

		// Return on error
		$db->sql_return_on_error(true);

		foreach ($sql_query as $sql)
		{
			// Run the query and make sure that nothing went wrong
			$result = $db->sql_query($sql);
			if ($db->get_sql_error_triggered())
			{
				// Write the error result to the cache and return the user back
				// to the main page
				$error[] = $this->_format_sql_error($sql);
				continue;
			}

			if ($show_results)
			{				// Display the query
				$template->assign_block_vars('queries', array('QUERY' => $sql));

				$cnt = 0;

				if (is_bool($result) === false)
				{
					while ($row = $db->sql_fetchrow($result))
					{
						if ($cnt == 0)
						{
							// Assign the return fields
							foreach(array_keys($row) as $key)
							{
								$template->assign_block_vars('queries.headings', array('FIELD_NAME' => $key));
							}
						}

						// Set row class
						$template->assign_block_vars('queries.resultdata', array('ROWSTYLE' => ($cnt % 2 == 0) ? 1 : 2));

						// Output resultset
						foreach ($row as $value)
						{
							$template->assign_block_vars('queries.resultdata.resultdatafields', array('VALUE' => $value));
						}

						$cnt++;
					}
				}
			}

			$db->sql_freeresult($result);
		}

		$template->assign_vars(array(
			'L_SQL_QUERY_LEGEND'	=> user_lang('SQL_QUERY_LEGEND'),
			'L_QUERY_RESULT'		=> user_lang('QUERY_RESULT'),
			)
		);

		// Purge the cache
		$cache->purge();

		if (empty($error))
		{
			trigger_error(user_lang('SQL_QUERY_SUCCESS'));
		}
	}

	/**
	 * Format the error message for the failed query
	 * @param  String $sql        The failed query
	 * @return String the message
	 */
	function _format_sql_error($sql)
	{
		global $db;

		$error	= $db->sql_error($sql);
		$msg	= 'SQL ERROR [ ' . $db->get_sql_layer() . ' ]<br /><br />' . $error['message'] . ' [' . $error['code'] . ']';

		// Create some html to also embed the query
		$return = $msg . '<dl class="codebox querybox">
			<dt>' . user_lang('ERROR_QUERY') . "</dt>
			<dd><code>{$sql}</code></dd>
		</dl>";

		return $return;
	}
}
