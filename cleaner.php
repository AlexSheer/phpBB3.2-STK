<?php
/**
*
* @package Support Toolkit
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

define('IN_PHPBB', true);

if (!defined('PHPBB_ROOT_PATH')) { define('PHPBB_ROOT_PATH', './../'); }
if (!defined('PHP_EXT')) { define('PHP_EXT', substr(strrchr(__FILE__, '.'), 1)); }
if (!defined('STK_DIR_NAME')) { define('STK_DIR_NAME', substr(strrchr(dirname(__FILE__), DIRECTORY_SEPARATOR), 1)); }	// Get the name of the stk directory
if (!defined('STK_ROOT_PATH')) { define('STK_ROOT_PATH', './'); }
if (!defined('STK_INDEX')) { define('STK_INDEX', STK_ROOT_PATH . 'index.' . PHP_EXT); }

if (file_exists(STK_ROOT_PATH . 'default_lang.txt'))
{
	$default_lang = trim(file_get_contents(STK_ROOT_PATH . 'default_lang.txt'));
	if (empty($default_lang))
	{
		$default_lang = 'en';
	}
}
else
{
	$default_lang = 'en';
}

require PHPBB_ROOT_PATH . 'language/' . $default_lang . '/common.' . PHP_EXT;
require STK_ROOT_PATH . 'language/' . $default_lang . '/ext_cleaner.' . PHP_EXT;
require STK_ROOT_PATH . 'language/' . $default_lang . '/common.' . PHP_EXT;
require PHPBB_ROOT_PATH . 'config.' . PHP_EXT;

define('EXT_TABLE',			'' . $table_prefix . 'ext');
define('MIGRATIONS_TABLE',	'' . $table_prefix . 'migrations');

$error = array();
$cache = PHPBB_ROOT_PATH . 'cache/production';

$login = chk_auth();

$enter			= request_var('enter', false);
$action			= request_var('action', '');
if ($login)
{
	hdr($default_lang, $login);

	$link = @mysqli_connect($dbhost, $dbuser, $dbpasswd, $dbname);
	if (!$link)
	{
		$pass = ($src_dbpasswd) ? 'YES' : 'NO';
		$error = '' . $lang['DB_CONNECT_PASS_ERROR'] . ' Access denied for user ' . $src_dbuser . '@' . $src_dbhost . ' (using password: ' . $pass . ')';
		_trigger_error($error, E_USER_WARNING);
		exit;
	}
	else if (!mysqli_select_db($link, $dbname))
	{
		$error = sprintf($lang['DB_CONNECT_ERROR'], mysqli_error($link));
		_trigger_error($error, E_USER_WARNING);
		exit;
	}

	$sql = 'SHOW TABLES LIKE \'' . EXT_TABLE . '\'';

	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_row($result);
	if (empty($row))
	{
		$error = '' . sprintf($lang['DB_CONNECT_ERROR'], mysqli_error($link)) . '' . $lang['TABLE_NOT_EXISTS'] . '';
		_trigger_error($error, true);
		exit;
	}
	mysqli_free_result($result);

	$submit			= request_var('submit', false);
	$uids			= request_var('marked_name', array('', ''));
	$off			= request_var('off', false);
	$enable			= request_var('enable', false);
	$no_composer = false;

	if ($off)
	{
		if (empty($uids))
		{
			_trigger_error($lang['NO_EXT_SELECTED'], E_USER_WARNING);
		}
		else
		{
			$sql = 'UPDATE ' . EXT_TABLE . '
				SET ext_active = 0
				WHERE ' . sql_in_set('ext_name', $uids);
			mysqli_query($link, $sql);
			purge_cache($cache);
			_trigger_error($lang['OFF_EXT_SUCCESS']);
		}
	}

	if ($enable)
	{
		if (empty($uids))
		{
			_trigger_error($lang['NO_EXT_SELECTED'], E_USER_WARNING);
		}
		else
		{
			$sql = 'UPDATE ' . EXT_TABLE . '
				SET ext_active = 1
				WHERE ' . sql_in_set('ext_name', $uids);
			mysqli_query($link, $sql);
			purge_cache($cache);
			_trigger_error($lang['ON_EXT_SUCCESS']);
		}
	}

	if ($submit)
	{
		if (empty($uids))
		{
			_trigger_error($lang['NO_EXT_SELECTED'], E_USER_WARNING);
		}
		else
		{
			$sql = 'SELECT ext_name FROM ' . EXT_TABLE . '
				WHERE ' . sql_in_set('ext_name', $uids, false);
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_row($result))
			{
				$ext_name = explode('/', $row['0']);
				$keyword = '*' . $ext_name[1] . '*';
				$sql = 'DELETE FROM ' . MIGRATIONS_TABLE . '
					WHERE migration_name ' . sql_like_expression(str_replace('*', '%', $keyword));
				mysqli_query($link, $sql);
			}
			mysqli_free_result($result);

			$sql = 'DELETE FROM ' . EXT_TABLE . '
				WHERE ' . sql_in_set('ext_name', $uids, false);
			mysqli_query($link, $sql);
			purge_cache($cache);
			_trigger_error($lang['REMOVE_EXT_SUCCESS']);
		}
	}

	$sql = 'SELECT * FROM ' . EXT_TABLE . '';
	$result = mysqli_query($link, $sql);
	$count = $result->{'num_rows'};
	if ($count)
	{
			?>
									<table cellspacing="1">
										<tr>
											<th><? echo($lang['EXT_NAME']); ?></th>
											<th><? echo($lang['EXT_PATH']); ?></th>
											<th><? echo($lang['MISSING_PATH']); ?></th>
											<th class="mark"><? echo($lang['MARK']); ?></th>
										</tr>
			<?
	}
	else
	{
		_trigger_error($lang['NO_EXTENSIONS_TEXT'], true);
	}
	$count = 0;
	while ($row = mysqli_fetch_row($result))
	{
		$count++;
		if ($count%2)
		{
			echo"\t\t\t\t<tr class='row1'>\n";
		}
		else
		{
			echo"\t\t\t\t<tr class='row2'>\n";
		}
		echo"\t\t\t\t<td>";
		$path = explode('/', $row[0]);
		$display_name = $root = $missing_path = '';
		foreach ($path as $key => $ext_path)
		{
			if ($dir = @opendir('' . PHPBB_ROOT_PATH . 'ext/' . $root . '' . $ext_path . ''))
			{
				$file = readdir($dir);
				$root = '' . $ext_path . '/';
			}
			else
			{
				$missing_path = $ext_path;
				break;
			}
		}

		if (!$missing_path)
		{
			if (file_exists('' . PHPBB_ROOT_PATH . 'ext/' . $row[0] . '/composer.json'))
			{
				$buffer =  file_get_contents('' . PHPBB_ROOT_PATH . 'ext/' . $row[0] . '/composer.json');
				if ($buffer)
				{
					$obj = json_decode($buffer);
					$display_name = $obj->{'extra'}->{'display-name'};
				}

			}
			else
			{
				$no_composer = true;
			}
		}

		$style = ($row[1]) ? '<span style ="color:#228822;"> ' . $lang['S_ACTIVE'] . '</span>' : '<span style ="color:#BC2A4D;"> ' . $lang['S_OFF'] . '</span>';
		$display_name = ($display_name) ? $display_name : '<span style ="color:#BC2A4D;">' . $row[0] . '</span>';
		echo "<strong>$display_name</strong>" . $style . "";

		echo "<td>" . $row[0] . "</td>\n\t";
		echo "<td><span style ='color:#BC2A4D; font-weight:bold;'>" .  $missing_path . "</span></td>\n\t";
		echo '<td class="mark">';
		echo "<input type='checkbox' style='cursor:default;' name='marked_name[]' value='" . $row[0] . "'>";
		echo "</td>\n</tr>\n";
	}
	mysqli_free_result($result);
	echo "\t\t\t\t\t\t</table>\n";
	if ($count)
	{
?>
							<div class="rightside pagination"><a href="#" onclick="marklist('select_action', 'marked_name', true); return false;"><? echo($lang['MARK_ALL']); ?></a> :: <a href="#" onclick="marklist('select_action', 'marked_name', false); return false;"><? echo($lang['UNMARK_ALL']); ?></a></div>
							<fieldset class="jumpbox">
								<label for="submit"><? echo($lang['CLICK_TO_CLEAR']); ?></label> <div style="text-align: right;"><input type="submit" name="submit" class="button2" style="float: right;" value="<? echo($lang['DELETE']); ?>"></div>
							</fieldset>
							<fieldset class="jumpbox">
								<label for="off"><? echo($lang['CLICK_TO_OFF']); ?></label> <input type="submit" name="off" class="button2" style="float: right;" value="<? echo($lang['OFF_EXT']); ?>">
							</fieldset>
							<fieldset class="jumpbox">
								<label for="enable"><? echo($lang['CLICK_TO_ON']); ?></label> <input type="submit" name="enable" class="button2" style="float: right;" value="<? echo($lang['ON_EXT']); ?>">
							</fieldset>
							<input type="hidden" name="enter" value="1">
						</form>
<?
	}
}
else
{
	$passwd = request_var('pass', '');
	if ($enter)
	{
		if ($passwd)
		{
			if (file_exists(STK_ROOT_PATH . 'passwd.' . PHP_EXT))
			{
				include (STK_ROOT_PATH . 'passwd.' . PHP_EXT);
				if ($passwd == $stk_passwd)
				{
					setcookie('dpasswdfile', $passwd, (time() + 21600));
					$login = true;
				}
				else
				{
					$error[] = $lang['WRONG_PASSWD'];
				}
			}
		}
		else
		{
			$error[] = $lang['EMPTY_PASSWD'];
		}
	}
	if ($action == 'downloadpasswdfile')
	{
		$_pass_string			= request_var('stk_passwd', '');
		$_pass_exprire			= request_var('pass_exprire', '');
		setcookie('dpasswdfile', '', 0);
		// Create the file and let the user download it
		header('Content-Type: text/x-delimtext; name="passwd.' . PHP_EXT . '"');
		header('Content-disposition: attachment; filename=passwd.' . PHP_EXT);

		print ("<?php
/**
* Support Toolkit emergency password.
* The file was generated on: " . date('d/M/Y H:i.s', $_pass_exprire  - 21600)) . " and will expire on: " . date('d/M/Y H:i.s', $_pass_exprire) . ".
*/

// This file can only be from inside the Support Toolkit
if (!defined('IN_PHPBB'))
{
	exit;
}

\$stk_passwd\t\t\t\t= '{$_pass_string}';
\$stk_passwd_expiration\t= {$_pass_exprire};
";
			exit_handler();
	}
	hdr($default_lang, $login);

	if (sizeof($error))
	{
		echo ('<div class="errorbox">' . implode('<br />', $error) . '</div>');
	}
	if (file_exists(STK_ROOT_PATH . 'passwd.' . PHP_EXT) && !$login)
	{
		?>
							<fieldset class="jumpbox">
							<legend><? echo($lang['EMERGENCY_LOGIN_NAME']); ?></legend>
								<dl>
									<dt><label for="pass"><? echo($lang['STK_PASSWORD']); ?>:</label></dt>
									<dd><input id="pass" type="text" size="60" maxlength="255" name="pass"  value=""></dd>
								</dl>
								<input type="submit" name="enter" class="button2" value="<? echo($lang['SUBMIT']); ?>">
							</fieldset>
		<?
	}
	else if (!$action && !$login)
	{
		$redirect = STK_ROOT_PATH . 'cleaner.' . PHP_EXT . '?action=genpasswdfile';
		?>
		<fieldset>
			<legend><? echo ($lang['DOWNLOAD_PASS']); ?></legend>
			<p>
				<? echo (sprintf($lang['GEN_PASS_FILE_EXPLAIN'], $redirect)); ?>
			</p>
		</fieldset>
		<?
	}
	if ($action == 'genpasswdfile')
	{
		$_pass_string = md5(generatecode(10));
		$_pass_exprire = time() + 21600;
		$redirect = STK_ROOT_PATH . 'cleaner.' . PHP_EXT . '';

		echo (sprintf($lang['PASS_GENERATED'], $_pass_string, date('d M Y H:i.s', $_pass_exprire)));
		?>
		<p class="submit-buttons">
			<input class="button1" type="submit" id="download_passwd" name="download_passwd" value="<? echo ($lang['DOWNLOAD_PASS']) ?>">
			<input name="action" type="hidden" value="downloadpasswdfile">
			<input name="stk_passwd" type="hidden" value="<? echo($_pass_string); ?>">
			<input name="pass_exprire" type="hidden" value="<? echo($_pass_exprire); ?>">
		</p>
		<?
		echo (sprintf($lang['PASS_GENERATED_REDIRECT'], $redirect));
	}
	echo "\t\t\t\t</form>\n";
	if ($login)
	{
		$redirect = STK_ROOT_PATH . 'cleaner.' . PHP_EXT;
		redirect($redirect);
	}
}
footer();


function redirect($url)
{
	echo '<script type="text/javascript">window.location = "' . $url . '"</script>';
}
function hdr($default_lang, $login = false, $count = 0)
{
	global $lang;

	$u_undex = PHPBB_ROOT_PATH . 'index.' . PHP_EXT;
	$u_acp = PHPBB_ROOT_PATH . 'adm/index.' . PHP_EXT;
	$u_stk = STK_ROOT_PATH . 'index.' . PHP_EXT;

	echo "<!DOCTYPE html>\n<html lang=" . $default_lang . ">\n<head>\n<meta charset='utf-8' />\n";
	if ($login)
	{
		?>
<script>
/**
* Mark/unmark checkboxes
* id = ID of parent container, name = name prefix, state = state [true/false]
*/
function marklist(id, name, state)
{
	var parent = document.getElementById(id);
	if (!parent)
	{
		eval('parent = document.' + id);
	}
	if (!parent)
	{
		return;
	}
	var rb = parent.getElementsByTagName('input');
	for (var r = 0; r < rb.length; r++)
	{
		if (rb[r].name.substr(0, name.length) == name)
		{
			rb[r].checked = state;
		}
	}
}
</script>
		<?
	}
	?>
<title>STK - <?php echo ($lang['CLEAR_EXTENSIONS']); ?></title>
<link href="<?php echo (STK_ROOT_PATH); ?>/style/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrap">
	<div id="page-header">
		<h1>STK</h1>
			<p><a href="<? echo($u_stk); ?>"><? echo ($lang['SUPPORT_TOOL_KIT_INDEX']); ?></a> &bull; <a href="<? echo ($u_acp); ?>"><? echo ($lang['ACP']); ?></a> &bull; <a href="<? echo ($u_undex); ?>"><? echo ($lang['FORUM_INDEX']); ?></a></p>
		</div>
		<div id="page-body">
			<div id="acp">
				<div class="panel">
					<div id="content">
						<div>
							<h1><? echo ($lang['CLEAR_EXTENSIONS']); ?></h1>
							<p><? echo ($lang['CLEAR_EXTENSIONS_EXPLAIN']); ?></p>
							<form method="post" id="select_action" action="cleaner.php">
	<?
		if ($login && $count)
		{
			?>
									<table cellspacing="1">
										<tr>
											<th><? echo($lang['EXT_NAME']); ?></th>
											<th><? echo($lang['EXT_PATH']); ?></th>
											<th><? echo($lang['MISSING_PATH']); ?></th>
											<th class="mark"><? echo($lang['MARK']); ?></th>
										</tr>
			<?
		}
	}

	function footer()
	{
	?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="copyright">
	Support Toolkit for phpBB3.2.x &amp; phpBB3.3.x &copy;<br>
	Powered by <a href="http://www.phpbb.com/">phpBB</a>&reg; Forum Software &copy; phpBB Group - adaptation for phpBB3.2.x &amp; phpBB3.3.x by &copy; Sheer
</div>
</body>
</html>
<?
}

function generatecode($length = 6)
{
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
	$code = '';
	$clen = strlen($chars) - 1;
	while (strlen($code) < $length)
	{
		$code .= $chars[mt_rand(0, $clen)];
	}
	return $code;
}

function exit_handler()
{
	// As a pre-caution... some setups display a blank page if the flush() is not there.
	(ob_get_level() > 0) ? @ob_flush() : @flush();

	exit;
}

function chk_auth()
{
	if (file_exists(STK_ROOT_PATH . 'passwd.' . PHP_EXT))
	{
		include (STK_ROOT_PATH . 'passwd.' . PHP_EXT);
		if ($stk_passwd_expiration !== false && time() < $stk_passwd_expiration)
		{
			$cookie = request_var('dpasswdfile', '', false, true);
			if ($stk_passwd === $cookie)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		setcookie('dpasswdfile', '', 0);
		@unlink(STK_ROOT_PATH . 'passwd.' . PHP_EXT);
		return false;
	}
	return false;
}

function _trigger_error($msg, $error_level = '')
{
	$class = ($error_level) ? 'errorbox' : 'successbox';
	echo ('<div class="' . $class . '"> ' . $msg . '</div>');
}

function purge_cache($path)
{
	$files = glob($path . '/*');
	foreach ($files as $file)
	{
		is_dir($file) ? purge_cache($file) : unlink($file);
	}
	@rmdir($path);
	return;
}

function sql_like_expression($expression)
{
	$expression = str_replace(array('_', '%'), array("\_", "\%"), $expression);
	$expression = str_replace(array(chr(0) . "\_", chr(0) . "\%"), array('_', '%'), $expression);

	return ('LIKE \'' . $expression . '\'');
}

function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
{
	if (!sizeof($array))
	{
		if (!$allow_empty_set)
		{
			trigger_error('No values specified for SQL IN comparison');
		}
		else
		{
			// NOT IN () actually means everything so use a tautology
			if ($negate)
			{
				return '1=1';
			}
			// IN () actually means nothing so use a contradiction
			else
			{
				return '1=0';
			}
		}
	}

	if (!is_array($array))
	{
		$array = array($array);
	}

	if (sizeof($array) == 1)
	{
		@reset($array);
		$var = current($array);

		return $field . ($negate ? ' <> ' : ' = ') . sql_validate_value($var);
	}
	else
	{
		$sql_array = array();
		foreach ($array as $var)
		{
			$sql_array[] = sql_validate_value($var);
		}
		return $field . ($negate ? ' NOT IN ' : ' IN ') . '(' . implode(', ', $sql_array) . ')';
	}
}

function sql_validate_value($var)
{
	if (is_null($var))
	{
		return 'NULL';
	}
	else if (is_string($var))
	{
		return "'" . sql_escape($var) . "'";
	}
	else
	{
		return (is_bool($var)) ? intval($var) : $var;
	}
}

function sql_escape($var)
{
	global $link;

	return @mysqli_real_escape_string($link, $var);
}

function request_var($var_name, $default, $multibyte = false, $cookie = false)
{
	if (!$cookie && isset($_COOKIE[$var_name]))
	{
		if (!isset($_GET[$var_name]) && !isset($_POST[$var_name]))
		{
			return (is_array($default)) ? array() : $default;
		}
		$_REQUEST[$var_name] = isset($_POST[$var_name]) ? $_POST[$var_name] : $_GET[$var_name];
	}

	$super_global = ($cookie) ? '_COOKIE' : '_REQUEST';
	if (!isset($GLOBALS[$super_global][$var_name]) || is_array($GLOBALS[$super_global][$var_name]) != is_array($default))
	{
		return (is_array($default)) ? array() : $default;
	}

	$var = $GLOBALS[$super_global][$var_name];
	if (!is_array($default))
	{
		$type = gettype($default);
	}
	else
	{
		list($key_type, $type) = each($default);
		$type = gettype($type);
		$key_type = gettype($key_type);
		if ($type == 'array')
		{
			reset($default);
			$default = current($default);
			list($sub_key_type, $sub_type) = each($default);
			$sub_type = gettype($sub_type);
			$sub_type = ($sub_type == 'array') ? 'NULL' : $sub_type;
			$sub_key_type = gettype($sub_key_type);
		}
	}

	if (is_array($var))
	{
		$_var = $var;
		$var = array();

		foreach ($_var as $k => $v)
		{
			set_var($k, $k, $key_type);
			if ($type == 'array' && is_array($v))
			{
				foreach ($v as $_k => $_v)
				{
					if (is_array($_v))
					{
						$_v = null;
					}
					set_var($_k, $_k, $sub_key_type, $multibyte);
					set_var($var[$k][$_k], $_v, $sub_type, $multibyte);
				}
			}
			else
			{
				if ($type == 'array' || is_array($v))
				{
					$v = null;
				}
				set_var($var[$k], $v, $type, $multibyte);
			}
		}
	}
	else
	{
		set_var($var, $var, $type, $multibyte);
	}

	return $var;
}
function set_var(&$result, $var, $type, $multibyte = false)
{
	settype($var, $type);
	$result = $var;

	if ($type == 'string')
	{
		$result = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $result), ENT_COMPAT, 'UTF-8'));

		if (!empty($result))
		{
			// Make sure multibyte characters are wellformed
			if ($multibyte)
			{
				if (!preg_match('/^./u', $result))
				{
					$result = '';
				}
			}
			else
			{
				// no multibyte, allow only ASCII (0-127)
				$result = preg_replace('/[\x80-\xFF]/', '?', $result);
			}
		}

		$result = ('STRIP') ? stripslashes($result) : $result;
	}
}

?>

