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

class erk_config_repair
{
	function run()
	{
		if (!file_exists(PHPBB_ROOT_PATH . 'config.' . PHP_EXT))
		{
			$this->repair();
			header('Location: ' . STK_INDEX);
			exit;
		}
		return true;
	}
	function repair()
	{
		global $critical_repair, $user, $lang;

		$critical_repair->user_setup($user);

		include(STK_ROOT_PATH . 'includes/functions.' . PHP_EXT);
		include(STK_ROOT_PATH . 'language/' . $user->data['user_lang'] . '/common.' . PHP_EXT);
		include(PHPBB_ROOT_PATH . 'language/' . $user->data['user_lang'] . '/install.' . PHP_EXT);

		$available_dbms = $this->get_available_dbms();

		$error = array();
		$data = array(
			'dbms'			=> (isset($_POST['dbms'])) ? $_POST['dbms'] : '',
			'dbhost'		=> (isset($_POST['dbhost'])) ? $_POST['dbhost'] : '',
			'dbport'		=> (isset($_POST['dbport'])) ? $_POST['dbport'] : '',
			'dbname'		=> (isset($_POST['dbname'])) ? $_POST['dbname'] : '',
			'dbuser'		=> (isset($_POST['dbuser'])) ? $_POST['dbuser'] : '',
			'dbpasswd'		=> (isset($_POST['dbpasswd'])) ? $_POST['dbpasswd'] : '',
			'table_prefix'	=> (isset($_POST['table_prefix'])) ? $_POST['table_prefix'] : 'phpbb_',
		);

		if (isset($_POST['submit']))
		{
			if (!isset($available_dbms[$data['dbms']]))
			{
				$error[] = $lang['CONFIG_REPAIR_NO_DBMS'];
			}
			else
			{
				$connect_test = $this->critical_connect_check_db($user, true, $error, $available_dbms[$data['dbms']], $data['table_prefix'], $data['dbhost'], $data['dbuser'], htmlspecialchars_decode($data['dbpasswd']), $data['dbname'], $data['dbport']);
				if (!$connect_test)
				{
					$error[] = $lang['CONFIG_REPAIR_CONNECT_FAIL'];
				}
			}
		}

		if (isset($_POST['submit']) && empty($error))
		{
			// Time to convert the data provided into a config file
			$config_data = "<?php\n";
			$config_data .= "// phpBB 3.2.x auto-generated configuration file\n// Do not change anything in this file!\n";

			$config_data_array = array(
				'dbms'						=> $available_dbms[$data['dbms']]['DRIVER'],
				'dbhost'					=> $data['dbhost'],
				'dbport'					=> $data['dbport'],
				'dbname'					=> $data['dbname'],
				'dbuser'					=> $data['dbuser'],
				'dbpasswd'					=> htmlspecialchars_decode($data['dbpasswd']),
				'table_prefix'				=> $data['table_prefix'],
				'phpbb_adm_relative_path'	=> 'adm/',
				'acm_type'					=> 'phpbb\\cache\\driver\\file',
			);

			foreach ($config_data_array as $key => $value)
			{
				$config_data .= "\${$key} = '" . str_replace("'", "\\'", str_replace('\\', '\\\\', $value)) . "';\n";
			}
			unset($config_data_array);

			$config_data .= "\n@define('PHPBB_INSTALLED', true);\n";
			$config_data .= "// @define('PHPBB_DISPLAY_LOAD_TIME', true);\n";
			$config_data .= "@define('PHPBB_ENVIRONMENT', 'production');\n";
			$config_data .= "// @define('DEBUG', true);\n";
			$config_data .= "// @define('DEBUG_CONTAINER', true);\n";
			$config_data .= '?' . '>'; // Done this to prevent highlighting editors getting confused!

			// Assume it will work ... if nothing goes wrong below
			$written = true;

			if (!($fp = @fopen(PHPBB_ROOT_PATH . 'config.' . PHP_EXT, 'w')))
			{
				// Something went wrong ... so let's try another method
				$written = false;
			}

			if (!(@fwrite($fp, $config_data)))
			{
				// Something went wrong ... so let's try another method
				$written = false;
			}

			@fclose($fp);

			if ($written)
			{
				// We may revert back to chmod() if we see problems with users not able to change their config.php file directly
				chmod(PHPBB_ROOT_PATH . 'config.' . PHP_EXT, CHMOD_READ);
			}
			else
			{
				header('Content-type: text/html; charset=UTF-8');
				echo $lang['CONFIG_REPAIR_WRITE_ERROR'];
				echo nl2br(htmlspecialchars($config_data));
				exit;
			}
		}
		else
		{
			header('Content-type: text/html; charset=UTF-8');
			?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
		<head>
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<meta http-equiv="content-style-type" content="text/css" />
			<meta http-equiv="imagetoolbar" content="no" />
			<title>Config Repair - Support Toolkit</title>
			<link href="<?php echo STK_ROOT_PATH; ?>style/style.css" rel="stylesheet" type="text/css" media="screen" />
			<link href="<?php echo STK_ROOT_PATH; ?>style/erk_style.css" rel="stylesheet" type="text/css" media="screen" />
		</head>
		<body id="errorpage">
			<div id="wrap">
				<div id="page-header">

				</div>
				<div id="page-body">
					<div id="acp">
						<div class="panel">
							<span class="corners-top"><span></span></span>
								<div id="content">
									<h1><?php echo $lang['CONFIG_REPAIR']; ?></h1>
									<br />
									<p>
										<?php echo $lang['CONFIG_REPAIR_EXPLAIN']; ?>
									</p>
									<form id="stk" method="post" action="<?php echo STK_ROOT_PATH . 'erk.' . PHP_EXT; ?>" name="support_tool_kit">
																				<fieldset>
											<?php if (!empty($error)) {?>
												<div class="errorbox">
													<h3>Error</h3>
													<p><?php echo implode('<br />', $error); ?></p>
												</div>
											<?php } ?>
											<dl>
												<dt><label for="dbms"><?php echo $lang['DBMS']; ?>:</label></dt>
												<dd><select name="dbms">
													<?php foreach ($this->get_available_dbms() as $dbms => $dbms_data) { ?>
														<option value="<?php echo $dbms; ?>" <?php if ($data['dbms'] == $dbms) { echo ' selected="selected"'; } ?>><?php echo $dbms_data['LABEL']; ?>
													<?php } ?>
												</select></dd>
											</dl>
											<dl>
												<dt><label for="dbhost"><?php echo $lang['DB_HOST']; ?>:</label><br /><span class="explain"><?php echo $lang['DB_HOST_EXPLAIN']; ?></span></dt>
												<dd><input id="dbhost" type="text" value="<?php echo $data['dbhost']; ?>" name="dbhost" maxlength="100" size="25"/></dd>
											</dl>
											<dl>
												<dt><label for="dbport"><?php echo $lang['DB_PORT']; ?>:</label><br /><span class="explain"><?php echo $lang['DB_PORT_EXPLAIN']; ?></span></dt>
												<dd><input id="dbport" type="text" value="<?php echo $data['dbport']; ?>" name="dbport" maxlength="100" size="25"/></dd>
											</dl>
											<dl>
												<dt><label for="dbname"><?php echo $lang['DB_NAME']; ?>:</label></dt>
												<dd><input id="dbname" type="text" value="<?php echo $data['dbname']; ?>" name="dbname" maxlength="100" size="25"/></dd>
											</dl>
											<dl>
												<dt><label for="dbuser"><?php echo $lang['DB_USERNAME']; ?>:</label></dt>
												<dd><input id="dbuser" type="text" value="<?php echo $data['dbuser']; ?>" name="dbuser" maxlength="100" size="25"/></dd>
											</dl>
											<dl>
												<dt><label for="dbpasswd"><?php echo $lang['DB_PASSWORD']; ?>:</label></dt>
												<dd><input id="dbpasswd" type="password" value="" name="dbpasswd" maxlength="100" size="25"/></dd>
											</dl>
											<dl>
												<dt><label for="table_prefix"><?php echo $lang['TABLE_PREFIX']; ?>:</label></dt>
												<dd><input id="table_prefix" type="text" value="<?php echo $data['table_prefix']; ?>" name="table_prefix" maxlength="100" size="25"/></dd>
											</dl>
											<p class="submit-buttons">
												<input class="button1" type="submit" id="submit" name="submit" value="<?php echo $lang['SUBMIT']; ?>" />&nbsp;
												<input class="button2" type="reset" id="reset" name="reset" value="<?php echo $lang['CANCEL']; ?>" />
											</p>
										</fieldset>
									</form>
								</div>
							<span class="corners-bottom"><span></span></span>
						</div>
					</div>
				</div>
				<div id="page-footer">
					Support Toolkit for phpBB3.2.x &copy;</a><br />
					Powered by <a href="http://www.phpbb.com/">phpBB</a>&reg; Forum Software &copy; phpBB Group - adaptation for phpBB3.2.x by &copy; Sheer
				</div>
			</div>
		</body>
	</html>
			<?php
			exit;
		}
	}
	/**
	* Used to test whether we are able to connect to the database the user has specified
	* and identify any problems (eg there are already tables with the names we want to use
	* @param	array	$dbms should be of the format of an element of the array returned by {@link get_available_dbms get_available_dbms()}
	*					necessary extensions should be loaded already
	*/
	function critical_connect_check_db($user, $error_connect, &$error, $dbms_details, $table_prefix, $dbhost, $dbuser, $dbpasswd, $dbname, $dbport, $prefix_may_exist = false, $load_dbal = true, $unicode_check = true)
	{
		// Must be globalized here for when including the DB file
		global $phpbb_root_path, $phpEx, $lang;

		if(empty($dbname))
		{
			$error[] = $lang['INST_ERR_DB_NO_NAME'];
			return false;
		}

		$dbms = $dbms_details['SCHEMA'];

		if ($load_dbal)
		{
			// Include the DB layer
			include(PHPBB_ROOT_PATH . 'phpbb/db/driver/driver_interface.' . PHP_EXT);
			include(PHPBB_ROOT_PATH . 'phpbb/db/driver/driver.' . PHP_EXT);
			if ($dbms === 'mysql' || $dbms === 'mssql' || $dbms === 'mssqlnative')
			{
				$dbms_base = $dbms;
				if ($dbms === 'mysqli')
				{
					$dbms_base = 'mysql';
				}
				if ($dbms === 'mssqlnative')
				{
					$dbms_base = 'mssql';
				}
				include(PHPBB_ROOT_PATH . 'phpbb/db/driver/' . $dbms_base . '_base.' . PHP_EXT);
			}
			include(PHPBB_ROOT_PATH . 'phpbb/db/driver/' . $dbms . '.' . PHP_EXT);
			include(PHPBB_ROOT_PATH . 'phpbb/db/tools/tools_interface.' . PHP_EXT);
			include(PHPBB_ROOT_PATH . 'phpbb/db/tools/tools.' . PHP_EXT);
		}
		// Instantiate it and set return on error true
		$sql_db = 'dbal_' . $dbms;
		switch ($dbms_details['SCHEMA'])
		{
			case 'mysql':
			case 'mysqli':
				$db = new phpbb\db\driver\mysql();
			break;
			case 'mssql':
			case 'mssqlnative':
			case 'mssql_odbc':
				$db = new phpbb\db\driver\mssql();
			break;
			case 'postgres':
				$db = new phpbb\db\driver\postgres();
			break;
			case 'sqlite':
			case 'sqlite3':
				$db = new phpbb\db\driver\sqlite();
			break;
				case 'postgres':
				$db = new phpbb\db\driver\postgres();
			break;
		}

		$db->sql_return_on_error(true);

		// Check the prefix length to ensure that index names are not too long and does not contain invalid characters
		switch ($dbms_details['SCHEMA'])
		{
			case 'mysql':
			case 'mysqli':
				if (strspn($table_prefix, '-./\\') !== 0)
				{
					$error[] = $lang['INST_ERR_PREFIX_INVALID'];
					return false;
				}

			// no break;

			case 'postgres':
				$prefix_length = 36;
			break;

			case 'mssql':
			case 'mssqlnative':
			case 'mssql_odbc':
				$prefix_length = 90;
			break;

			case 'sqlite':
			case 'sqlite3':
				$prefix_length = 200;
			break;

			case 'oracle':
				$prefix_length = 6;
			break;
		}

		if (strlen($table_prefix) > $prefix_length)
		{
			$error[] = $lang['INST_ERR_PREFIX_TOO_LONG'];
			return false;
		}

		// Try and connect ...
		if (is_array($db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, true)))
		{
			$db_error = $db->sql_error();
			$error[] = ' ' . $lang['INST_ERR_DB_CONNECT'] . '' . '<br />' . (($db_error['message']) ? $db_error['message'] : '' . $lang['INST_ERR_DB_NO_ERROR'] . '');
		}
		else
		{
			// Make sure that the user has selected a sensible DBAL for the DBMS actually installed
			switch ($dbms_details['SCHEMA'])
			{
				case 'mysqli':
					if (version_compare(mysqli_get_server_info($db->db_connect_id), '4.1.3', '<'))
					{
						$error[] = $lang['INST_ERR_DB_NO_MYSQLI'];
					}
				break;

				case 'sqlite':
					if (version_compare(sqlite_libversion(), '2.8.2', '<'))
					{
						$error[] = $lang['INST_ERR_DB_NO_SQLITE'];
					}
				break;

				case 'sqlite3':
					if (version_compare(sqlite_libversion(), '3.6.15', '<'))
					{
						$error[] = $lang['INST_ERR_DB_NO_SQLITE3'];
					}
				break;

				case 'postgres':
					if ($unicode_check)
					{
						$sql = "SHOW server_encoding;";
						$result = $db->sql_query($sql);
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						if ($row['server_encoding'] !== 'UNICODE' && $row['server_encoding'] !== 'UTF8')
						{
							$error[] = $lang['INST_ERR_DB_NO_POSTGRES'];
						}
					}
				break;
			}

			$db_tools = new phpbb\db\tools\tools($db);
			$tables = $db_tools->sql_list_tables();

			if (!in_array($table_prefix . 'acl_options', $tables) || !in_array($table_prefix . 'config', $tables) || !in_array($table_prefix . 'forums', $tables))
			{
				$error[] = $lang['CONFIG_REPAIR_NO_TABLES'];
			}
		}

		if ($error_connect && empty($error))
		{
			return true;
		}
		return false;
	}

	function get_available_dbms()
	{		$supported_dbms = array(
			// Note: php 5.5 alpha 2 deprecated mysql.
			// Keep mysqli before mysql in this list.
			'mysqli'	=> array(
				'LABEL'			=> 'MySQL with MySQLi Extension',
				'SCHEMA'		=> 'mysql',
				'MODULE'		=> 'mysqli',
				'DELIM'			=> ';',
				'DRIVER'		=> 'phpbb\db\driver\mysqli',
				'AVAILABLE'		=> true,
				'2.0.x'			=> true,
			),
			'mysql'		=> array(
				'LABEL'			=> 'MySQL',
				'SCHEMA'		=> 'mysql',
				'MODULE'		=> 'mysql',
				'DELIM'			=> ';',
				'DRIVER'		=> 'phpbb\db\driver\mysql',
				'AVAILABLE'		=> true,
				'2.0.x'			=> true,
			),
			'mssql'		=> array(
				'LABEL'			=> 'MS SQL Server 2000+',
				'SCHEMA'		=> 'mssql',
				'MODULE'		=> 'mssql',
				'DELIM'			=> ';',
				'DRIVER'		=> 'phpbb\db\driver\mssql',
				'AVAILABLE'		=> true,
				'2.0.x'			=> true,
			),
			'mssql_odbc'=>	array(
				'LABEL'			=> 'MS SQL Server [ ODBC ]',
				'SCHEMA'		=> 'mssql',
				'MODULE'		=> 'odbc',
				'DELIM'			=> ';',
				'DRIVER'		=> 'phpbb\db\driver\mssql_odbc',
				'AVAILABLE'		=> true,
				'2.0.x'			=> true,
			),
			'mssqlnative'		=> array(
				'LABEL'			=> 'MS SQL Server 2005+ [ Native ]',
				'SCHEMA'		=> 'mssql',
				'MODULE'		=> 'sqlsrv',
				'DELIM'			=> ';',
				'DRIVER'		=> 'phpbb\db\driver\mssqlnative',
				'AVAILABLE'		=> true,
				'2.0.x'			=> false,
			),
			'oracle'	=>	array(
				'LABEL'			=> 'Oracle',
				'SCHEMA'		=> 'oracle',
				'MODULE'		=> 'oci8',
				'DELIM'			=> '/',
				'DRIVER'		=> 'phpbb\db\driver\oracle',
				'AVAILABLE'		=> true,
				'2.0.x'			=> false,
			),
			'postgres' => array(
				'LABEL'			=> 'PostgreSQL 8.3+',
				'SCHEMA'		=> 'postgres',
				'MODULE'		=> 'pgsql',
				'DELIM'			=> ';',
				'DRIVER'		=> 'phpbb\db\driver\postgres',
				'AVAILABLE'		=> true,
				'2.0.x'			=> true,
			),
			'sqlite'		=> array(
				'LABEL'			=> 'SQLite',
				'SCHEMA'		=> 'sqlite',
				'MODULE'		=> 'sqlite',
				'DELIM'			=> ';',
				'DRIVER'		=> 'phpbb\db\driver\sqlite',
				'AVAILABLE'		=> true,
				'2.0.x'			=> false,
			),
			'sqlite3'		=> array(
				'LABEL'			=> 'SQLite3',
				'SCHEMA'		=> 'sqlite',
				'MODULE'		=> 'sqlite3',
				'DELIM'			=> ';',
				'DRIVER'		=> 'phpbb\db\driver\sqlite3',
				'AVAILABLE'		=> true,
				'2.0.x'			=> false,
			),
		);

		return $supported_dbms;	}
}
