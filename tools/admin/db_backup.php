<?php
/**
 *
 * @package Support Toolkit - Database Backup
 * @copyright (c) 2015 phpBBGuru Sheer
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
 * Make backup selected tables of database
 */
class db_backup
{
	function display_options()
	{
		global $db, $template, $config, $user, $lang, $request;

		$submit = $request->variable('sa', false);
		$tables = $request->variable('table_select', array(''));
		$gzip = $request->variable('gzip', true);
		$where = $request->variable('action', 'store');
		$type = $request->variable('type', 'full');
		$format = $request->variable('method', '', true);

		$sql_layer = $db->get_sql_layer();

		if($format === $lang['NO'])
		{
			$format = 'text';
		}

		$store = $download = $structure = $schema_data = $screen = false;
		if ($where == 'store')
		{
			$store = true;
		}

		if ($where == 'download')
		{
			$download = true;
		}

		if ($where == 'screen')
		{
			$format = 'screen';
		}

		if ($type == 'full' || $type == 'structure')
		{
			$structure = true;
		}

		if ($type == 'full' || $type == 'data')
		{
			$schema_data = true;
		}

		$available_methods = array('gzip' => 'zlib', 'bzip2' => 'bz2');
		foreach ($available_methods as $zip_type => $module)
		{
			if (!@extension_loaded($module))
			{
				continue;
			}

			$template->assign_block_vars('methods', array(
				'TYPE'	=> $zip_type
			));
		}
		$template->assign_block_vars('methods', array(
			'TYPE'	=> $lang['NO']
		));

		switch ($sql_layer)
		{
			case 'mysql':
			case 'mysql4':
			case 'mysqli':
				$sql = 'SHOW TABLES';
			break;

			case 'sqlite':
				$sql = 'SELECT name
					FROM sqlite_master
					WHERE type = "table"';
			break;

			case 'sqlite3':
				$sql = 'SELECT name
					FROM sqlite_master
					WHERE type = "table"
						AND name <> "sqlite_sequence"';
			break;

			case 'mssql':
			case 'mssql_odbc':
			case 'mssqlnative':
				$sql = "SELECT name
					FROM sysobjects
					WHERE type='U'";
			break;

			case 'postgres':
				$sql = 'SELECT relname
					FROM pg_stat_user_tables';
			break;

			case 'oracle':
				$sql = 'SELECT table_name
					FROM USER_TABLES';
			break;
		}

		$result = $db->sql_query($sql);

		$option_list = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$name = current($row);
			$option_list .= "<option value='{$name}'>{$name}</option>";
		}
		$db->sql_freeresult($result);

		if ($submit && !empty($tables))
		{
			$filename = 'back_' . $user->format_date(time(), 'Y_m_d_H_i_s');

			if($format == 'screen')
			{
				$template->assign_vars(array(
					'DUMP'	=> true,
				));

				$this->back($tables, $type);
			}
			else
			{
				$time = time();
				if ($sql_layer == 'mysqli' || $sql_layer == 'mysql4' || $sql_layer == 'mysql')
				{
					$extractor = new mysql_dumper_extractor($format, $filename, $time, $download, $store);
				}
				else
				{
					include PHPBB_ROOT_PATH . 'includes/acp/acp_database.' . PHP_EXT;
					switch ($db->get_sql_layer())
					{
						case 'sqlite':
							$extractor = new sqlite_extractor($format, $filename, $time, $download, $store);
						break;

						case 'sqlite3':
							$extractor = new sqlite3_extractor($format, $filename, $time, $download, $store);
						break;

						case 'postgres':
							$extractor = new postgres_extractor($format, $filename, $time, $download, $store);
						break;

						case 'oracle':
							$extractor = new oracle_extractor($format, $filename, $time, $download, $store);
						break;

						case 'mssql':
						case 'mssql_odbc':
						case 'mssqlnative':
							$extractor = new mssql_extractor($format, $filename, $time, $download, $store);
						break;
					}
				}

				$extractor->write_start($tables);

				foreach ($tables as $table_name)
				{
					// Get the table structure
					if ($structure)
					{
						$extractor->write_table($table_name);
					}
					else
					{
						// We might wanna empty out all that junk :D
						switch ($db->get_sql_layer())
						{
							case 'sqlite':
							case 'sqlite3':
								$extractor->flush('DELETE FROM ' . $table_name . ";\n");
							break;

							case 'mssql':
							case 'mssql_odbc':
							case 'mssqlnative':
								$extractor->flush('TRUNCATE TABLE ' . $table_name . "GO\n");
							break;

							case 'oracle':
								$extractor->flush('TRUNCATE TABLE ' . $table_name . "/\n");
							break;

							default:
							$extractor->flush('TRUNCATE TABLE ' . $table_name . ";\n/*!40000 ALTER TABLE `" . $table_name . "` DISABLE KEYS */;\n");
							break;
						}
					}
					// Data
					if ($schema_data)
					{
						$extractor->write_data($table_name);
					}
				}

				$extractor->write_end();

				if ($download == true)
				{
					exit;
				}

				meta_refresh(3, append_sid(STK_ROOT_PATH . 'index.' . PHP_EXT, 'c=admin&amp;t=db_backup'));
				trigger_error(user_lang('BACKUP_SUCCESS'));
			}
		}

		page_header(user_lang('DB_BACKUP'));

		$template->assign_vars(array(
			'S_SELECT'			=> $option_list,
			'SCREEN_ENABLE'		=> ($sql_layer == 'mysqli' || $sql_layer == 'mysql4' || $sql_layer == 'mysql') ? true : false,
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, 'c=admin&amp;t=db_backup&amp;go=1'),
		));

		$template->set_filenames(array(
			'body' => 'tools/db_backup.html',
		));

		page_footer();
	}

	function back($tables, $type)
	{
		global $db, $user, $template;

		$tables = is_array($tables) ? $tables : explode(',', $tables);
		$db_name = $db->get_db_name();

		$sql = 'SHOW TABLE STATUS
			WHERE ' . $db->sql_in_set('Name', $tables) . '';
		$result = $db->sql_query($sql);
		$table_count = $records = 0;
		while ($row = $db->sql_fetchrow($result))
		{
			$row_set[] = $row;
			$table_count++;
			$records = $records + $row['Rows'];
		}

		$data =	'-- Status:' . $table_count . ':' . $records . ':MP_0:' . $db_name . ':STK for phpBB3.2.x:' . STK_VERSION . '::' . $db->sql_server_info() . ':1:::utf8:EXTINFO<br />--<br />'.
				'-- TABLE-INFO<br />';

		foreach($row_set as $row)
		{
			$size = $row['Index_length'] + $row['Data_length'];
			$data .= '-- TABLE|' . $row['Name'] . '|' . $row['Rows'] . '|' . $size . '|' . $row['Update_time'] . '|' . $row['Engine'] . '<br />';
		}
		$db->sql_freeresult($result);
		unset($row_set);
		unset($row);

		$template->assign_block_vars('row', array(
			'DATA'	=> $data,
		));

		foreach($tables as $table_name)
		{
			$data = '';
			if ($type == 'full' || $type == 'structure')
			{
				$data .= '<br />--'.
						'<br />-- Create Table `' . $table_name . '`'.
						'<br />--<br />';
				$data .= 'DROP TABLE IF EXISTS `' . $table_name . '`;<br />';
				$sql = 'SHOW CREATE TABLE ' . $table_name . '';
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$data .= $row['Create Table'].";<br />";
				$db->sql_freeresult($result);
				$template->assign_block_vars('row', array(
					'DATA'	=> str_replace("\n", '<br />', $data),
				));
			}

			$template->assign_block_vars('row', array(
				'DATA'	=> '<br />--<br />-- Data for Table `' . $table_name . '`<br />--<br />/*!40000 ALTER TABLE `' . $table_name . '` DISABLE KEYS */;<br />',
			));

			$query_len		= 0;
			$max_len		= get_dbusable_memory();
			$dump = '';
			if ($type == 'full' || $type == 'data')
			{
				$sql = 'SELECT * FROM ' . $table_name . '';
				$result = $db->sql_query($sql);
				$num_rows = $db->get_estimated_row_count($table_name);

				if($num_rows > 0)
				{
					$vals = $items = array();
					$z = 0;
					for($i = 0; $i < $num_rows; $i++)
					{
						$row = $db->sql_fetchrow($result);
						foreach($row as $key => $value)
						{
							$items[] = $value;
						}

						$vals[$z] = 'INSERT INTO ' . $table_name . ' VALUES (';
						for($j = 0; $j < count($items); $j++)
						{
							if (isset($items[$j]))
							{
								$vals[$z] .= "'" . $db->sql_escape($items[$j]) . "'";
							}
							else
							{
								$vals[$z] .= 'NULL';
							}
							if ($j<(count($items) - 1))
							{
								$vals[$z] .= ',';
							}
						}
						$vals[$z] .= ');<br />';
						$dump .= $vals[$z];
						$query_len += strlen($dump);
						if ($query_len > $max_len)
						{
							$template->assign_block_vars('row', array(
								'I' => $i,
								'DATA'	=> $dump,
							));
							$dump = $vals[$z] = '';
							$query_len = 0;
							unset($items);
						}
						$z++;
						unset($items);
					}
					$db->sql_freeresult($result);
				}

				if ($dump)
				{
					// Rest of dump
					$template->assign_block_vars('row', array(
						'DATA'	=> $dump,
					));
					$dump = '';
					unset($items);
					unset($vals);
				}
			}

			$template->assign_block_vars('row', array(
				'DATA'	=> '/*!40000 ALTER TABLE `' . $table_name . '` ENABLE KEYS */;<br /><br />',
			));
		}

		$template->assign_block_vars('row', array(
			'DATA'	=> 'SET FOREIGN_KEY_CHECKS=1;<br />-- EOB<br />',
		));
	}
}

class dbbase_extractor
{
	var $fh;
	var $fp;
	var $write;
	var $close;
	var $store;
	var $download;
	var $time;
	var $format;
	var $run_comp = false;

	function dbbase_extractor($format, $filename, $time, $download = false, $store = false)
	{
		global $request, $lang;

		$this->download = $download;
		$this->store = $store;

		$this->time = $time;
		$this->format = $format;

		switch ($format)
		{
			case 'text':
				$ext = '.sql';
				$open = 'fopen';
				$this->write = 'fwrite';
				$this->close = 'fclose';
				$mimetype = 'text/x-sql';
			break;
			case 'bzip2':
				$ext = '.sql.bz2';
				$open = 'bzopen';
				$this->write = 'bzwrite';
				$this->close = 'bzclose';
				$mimetype = 'application/x-bzip2';
			break;
			case 'gzip':
				$ext = '.sql.gz';
				$open = 'gzopen';
				$this->write = 'gzwrite';
				$this->close = 'gzclose';
				$mimetype = 'application/x-gzip';
			break;
		}

		if ($download == true)
		{
			$name = $filename . $ext;
			header('Cache-Control: private, no-cache');
			header("Content-Type: $mimetype; name=\"$name\"");
			header("Content-disposition: attachment; filename=$name");

			switch ($format)
			{
				case 'bzip2':
					ob_start();
				break;

				case 'gzip':
					if (strpos($request->header('Accept-Encoding'), 'gzip') !== false && strpos(strtolower($request->header('User-Agent')), 'msie') === false)
					{
						ob_start('ob_gzhandler');
					}
					else
					{
						$this->run_comp = true;
					}
				break;
			}
		}

		if ($store == true)
		{
			global $phpbb_root_path;
			$file = $phpbb_root_path . 'store/' . $filename . $ext;

			$this->fp = $open($file, 'w');

			if (!$this->fp)
			{
				trigger_error($lang['FILE_WRITE_FAIL'], E_USER_ERROR);
			}
		}
	}

	function write_end()
	{
		static $close;
		$this->flush("SET FOREIGN_KEY_CHECKS=1;\n-- EOB\n");

		if ($this->store)
		{
			if ($close === null)
			{
				$close = $this->close;
			}
			$close($this->fp);
		}

		// bzip2 must be written all the way at the end
		if ($this->download && $this->format === 'bzip2')
		{
			$c = ob_get_clean();
			echo bzcompress($c);
		}
	}

	function flush($data)
	{
		static $write;
		if ($this->store === true)
		{
			if ($write === null)
			{
				$write = $this->write;
			}
			$write($this->fp, $data);
		}

		if ($this->download === true)
		{
			if ($this->format === 'bzip2' || $this->format === 'text' || ($this->format === 'gzip' && !$this->run_comp))
			{
				echo $data;
			}

			// we can write the gzip data as soon as we get it
			if ($this->format === 'gzip')
			{
				if ($this->run_comp)
				{
					echo gzencode($data);
				}
				else
				{
					ob_flush();
					flush();
				}
			}
		}
	}
}

class mysql_dumper_extractor extends dbbase_extractor
{
	function write_start($tables)
	{
		global $db, $user;

		$tables = is_array($tables) ? $tables : explode(',', $tables);
		$db_name = $db->get_db_name();

		$sql = 'SHOW TABLE STATUS
			WHERE ' . $db->sql_in_set('Name', $tables) . '';
		$result = $db->sql_query($sql);
		$table_count = $records = 0;
		while ($row = $db->sql_fetchrow($result))
		{
			$row_set[] = $row;
			$table_count++;
			$records = $records + $row['Rows'];
		}

		$data =	"-- Status:" . $table_count . ":" . $records . ":MP_0:" . $db_name . ":STK for phpBB3.2.x:" . STK_VERSION . "::" . $db->sql_server_info() . ":1:::utf8:EXTINFO\n--\n".
				"-- TABLE-INFO\n";

		foreach($row_set as $row)
		{
			$size = $row['Index_length'] + $row['Data_length'];
			$data .= "-- TABLE|" . $row['Name'] . "|" . $row['Rows'] . "|" . $size . "|" . $row['Update_time'] . "|" . $row['Engine'] . "\n";
		}
		$db->sql_freeresult($result);

		$data .="-- EOF TABLE-INFO\n--\n".
				'-- Dump created by Support Toolkit for phpBB3.2.x and compatible with MySQLDumper 1.24.4 (http://mysqldumper.net)'.
				"\n/*!40101 SET NAMES 'utf8' */;".
				"\nSET FOREIGN_KEY_CHECKS=0;".
				"\n-- Dump created: " . $user->format_date(time(), 'Y-m-d H:i') . "\n";
		$this->flush($data);
	}

	function write_table($table_name)
	{
		global $db;
		static $new_extract;

		if ($new_extract === null)
		{
			if ($db->get_sql_layer() === 'mysqli' || version_compare($db->sql_server_info(true), '3.23.20', '>='))
			{
				$new_extract = true;
			}
			else
			{
				$new_extract = false;
			}
		}

		if ($new_extract)
		{
			$this->new_write_table($table_name);
		}
		else
		{
			$this->old_write_table($table_name);
		}
	}

	function write_data($table_name)
	{
		global $db;
		if ($db->get_sql_layer() === 'mysqli')
		{
			$this->write_data_mysqli($table_name);
		}
		else
		{
			$this->write_data_mysql($table_name);
		}
	}

	function write_data_mysqli($table_name)
	{
		global $db;
		$sql = "SELECT *
			FROM $table_name";
		$result = mysqli_query($db->get_db_connect_id(), $sql, MYSQLI_USE_RESULT);
		if ($result != false)
		{
			$fields_cnt = mysqli_num_fields($result);

			// Get field information
			$field = mysqli_fetch_fields($result);
			$field_set = array();

			for ($j = 0; $j < $fields_cnt; $j++)
			{
				$field_set[] = $field[$j]->name;
			}

			$search			= array("\\", "'", "\x00", "\x0a", "\x0d", "\x1a", '"');
			$replace		= array("\\\\", "\\'", '\0', '\n', '\r', '\Z', '\\"');
			$fields			= implode(', ', $field_set);
			$sql_data		= 'INSERT INTO ' . $table_name . ' (' . $fields . ') VALUES ';
			$first_set		= true;
			$query_len		= 0;
			$max_len		= get_dbusable_memory();

			while ($row = mysqli_fetch_row($result))
			{
				$values	= array();
				if ($first_set)
				{
					$query = $sql_data . '(';
				}
				else
				{
					$query  .= ',(';
				}

				for ($j = 0; $j < $fields_cnt; $j++)
				{
					if (!isset($row[$j]) || is_null($row[$j]))
					{
						$values[$j] = 'NULL';
					}
					else if (($field[$j]->flags & 32768) && !($field[$j]->flags & 1024))
					{
						$values[$j] = $row[$j];
					}
					else
					{
						$values[$j] = "'" . str_replace($search, $replace, $row[$j]) . "'";
					}
				}
				$query .= implode(', ', $values) . ')';

				$query_len += strlen($query);
				if ($query_len > $max_len)
				{
					$this->flush($query . ";\n\n");
					$query = '';
					$query_len = 0;
					$first_set = true;
				}
				else
				{
					$first_set = false;
				}
			}
			mysqli_free_result($result);

			// check to make sure we have nothing left to flush
			if (!$first_set && $query)
			{
				$this->flush($query . ";\n/*!40000 ALTER TABLE `" . $table_name . "` ENABLE KEYS */;\n\n");
			}
		}
	}

	function write_data_mysql($table_name)
	{
		global $db;
		$sql = "SELECT *
			FROM $table_name";
		$result = mysql_unbuffered_query($sql, $db->get_db_connect_id());

		if ($result != false)
		{
			$fields_cnt = mysql_num_fields($result);

			// Get field information
			$field = array();
			for ($i = 0; $i < $fields_cnt; $i++)
			{
				$field[] = mysql_fetch_field($result, $i);
			}
			$field_set = array();

			for ($j = 0; $j < $fields_cnt; $j++)
			{
				$field_set[] = $field[$j]->name;
			}

			$search			= array("\\", "'", "\x00", "\x0a", "\x0d", "\x1a", '"');
			$replace		= array("\\\\", "\\'", '\0', '\n', '\r', '\Z', '\\"');
			$fields			= implode(', ', $field_set);
			$sql_data		= 'INSERT INTO ' . $table_name . ' (' . $fields . ') VALUES ';
			$first_set		= true;
			$query_len		= 0;
			$max_len		= get_dbusable_memory();

			while ($row = mysql_fetch_row($result))
			{
				$values = array();
				if ($first_set)
				{
					$query = $sql_data . '(';
				}
				else
				{
					$query  .= ',(';
				}

				for ($j = 0; $j < $fields_cnt; $j++)
				{
					if (!isset($row[$j]) || is_null($row[$j]))
					{
						$values[$j] = 'NULL';
					}
					else if ($field[$j]->numeric && ($field[$j]->type !== 'timestamp'))
					{
						$values[$j] = $row[$j];
					}
					else
					{
						$values[$j] = "'" . str_replace($search, $replace, $row[$j]) . "'";
					}
				}
				$query .= implode(', ', $values) . ')';

				$query_len += strlen($query);
				if ($query_len > $max_len)
				{
					$this->flush($query . ";\n\n");
					$query = '';
					$query_len = 0;
					$first_set = true;
				}
				else
				{
					$first_set = false;
				}
			}
			mysql_free_result($result);

			// check to make sure we have nothing left to flush
			if (!$first_set && $query)
			{
				$this->flush($query . ";\n/*!40000 ALTER TABLE `" . $table_name . "` ENABLE KEYS */;\n\n");
			}
		}
	}

	function new_write_table($table_name)
	{
		global $db;
		$sql = 'SHOW CREATE TABLE ' . $table_name;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);

		$sql_data = "\n--".
					"\n-- Create Table `" . $table_name . "`".
			 		"\n--\n\n";
		$sql_data .= "DROP TABLE IF EXISTS $table_name;\n";
		$sql_data .= $row['Create Table'] . ";\n\n";
		$sql_data .= "--\n-- Data for Table `" . $table_name . "`\n--\n\n/*!40000 ALTER TABLE `" . $table_name . "` DISABLE KEYS */;\n";

		$this->flush($sql_data);

		$db->sql_freeresult($result);
	}

	function old_write_table($table_name)
	{
		global $db;

		$sql_data = '# Table: ' . $table_name . "\n";
		$sql_data .= "DROP TABLE IF EXISTS $table_name;\n";
		$sql_data .= "CREATE TABLE $table_name(\n";
		$rows = array();

		$sql = "SHOW FIELDS
			FROM $table_name";
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$line = '   ' . $row['Field'] . ' ' . $row['Type'];

			if (!is_null($row['Default']))
			{
				$line .= " DEFAULT '{$row['Default']}'";
			}

			if ($row['Null'] != 'YES')
			{
				$line .= ' NOT NULL';
			}

			if ($row['Extra'] != '')
			{
				$line .= ' ' . $row['Extra'];
			}

			$rows[] = $line;
		}
		$db->sql_freeresult($result);

		$sql = "SHOW KEYS
			FROM $table_name";

		$result = $db->sql_query($sql);

		$index = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$kname = $row['Key_name'];

			if ($kname != 'PRIMARY')
			{
				if ($row['Non_unique'] == 0)
				{
					$kname = "UNIQUE|$kname";
				}
			}

			if ($row['Sub_part'])
			{
				$row['Column_name'] .= '(' . $row['Sub_part'] . ')';
			}
			$index[$kname][] = $row['Column_name'];
		}
		$db->sql_freeresult($result);

		foreach ($index as $key => $columns)
		{
			$line = '   ';

			if ($key == 'PRIMARY')
			{
				$line .= 'PRIMARY KEY (' . implode(', ', $columns) . ')';
			}
			else if (strpos($key, 'UNIQUE') === 0)
			{
				$line .= 'UNIQUE ' . substr($key, 7) . ' (' . implode(', ', $columns) . ')';
			}
			else if (strpos($key, 'FULLTEXT') === 0)
			{
				$line .= 'FULLTEXT ' . substr($key, 9) . ' (' . implode(', ', $columns) . ')';
			}
			else
			{
				$line .= "KEY $key (" . implode(', ', $columns) . ')';
			}

			$rows[] = $line;
		}

		$sql_data .= implode(",\n", $rows);
		$sql_data .= "\n);\n\n";

		$this->flush($sql_data);
	}
}

// get how much space we allow for a chunk of data, very similar to phpMyAdmin's way of doing things ;-) (hey, we only do this for MySQL anyway :P)
function get_dbusable_memory()
{
	$val = trim(@ini_get('memory_limit'));

	if (preg_match('/(\\d+)([mkg]?)/i', $val, $regs))
	{
		$memory_limit = (int) $regs[1];
		switch ($regs[2])
		{

			case 'k':
			case 'K':
				$memory_limit *= 1024;
			break;

			case 'm':
			case 'M':
				$memory_limit *= 1048576;
			break;

			case 'g':
			case 'G':
				$memory_limit *= 1073741824;
			break;
		}

		// how much memory PHP requires at the start of export (it is really a little less)
		if ($memory_limit > 6100000)
		{
			$memory_limit -= 6100000;
		}

		// allow us to consume half of the total memory available
		$memory_limit /= 2;
	}
	else
	{
		// set the buffer to 1M if we have no clue how much memory PHP will give us :P
		$memory_limit = 1048576;
	}

	return $memory_limit;
}
