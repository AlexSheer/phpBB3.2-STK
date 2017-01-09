<?php
/**
*
* @package Support Toolkit
* @copyright (c) 2016 Sheer
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

define('IN_PHPBB', true);

if (!defined('PHPBB_ROOT_PATH')) { define('PHPBB_ROOT_PATH', './../'); }
if (!defined('PHP_EXT')) { define('PHP_EXT', substr(strrchr(__FILE__, '.'), 1)); }
if (!defined('STK_DIR_NAME')) { define('STK_DIR_NAME', substr(strrchr(dirname(__FILE__), DIRECTORY_SEPARATOR), 1)); }	// Get the name of the stk directory
if (!defined('STK_ROOT_PATH')) { define('STK_ROOT_PATH', './'); }
if (!defined('STK_INDEX')) { define('STK_INDEX', STK_ROOT_PATH . 'index.' . PHP_EXT); }

require STK_ROOT_PATH . 'common.' . PHP_EXT;

// Setup the user
$user->session_begin();
$auth->acl($user->data);
$user->setup('acp/common', $config['default_style']);

if (!isset($user->data['session_admin']) || !$user->data['session_admin'])
{
	exit;
}
else
	// Only Board Founders may use the STK
	if ($user->data['user_type'] != USER_FOUNDER)
	{
		trigger_error('BOARD_FOUNDER_ONLY');
	}

// Language path.  We are using a custom language path to keep all the files within the stk/ folder.  First check if the $user->data['user_lang'] path exists, if not, check if the default lang path exists, and if still not use english.
stk_add_lang('common');
stk_add_lang('tools/ext/ext_finder');

// Do not use the normal template path (to prevent issues with boards using alternate styles)
$template->set_custom_style('stk', STK_ROOT_PATH . 'style');

$table		= $request->variable('t', '');
$column		= $request->variable('col', '');
$_config	= $request->variable('c', '');
$module		= $request->variable('m', '');
$permission	= $request->variable('p', '');

// Try get data from cache
$extra_data = $cache->get('_stk_ext');

if (!$extra_data)
{
	// No data in cache

	// Try to override some limits - maybe it helps some...
	@set_time_limit(0);
	$mem_limit = @ini_get('memory_limit');
	if (!empty($mem_limit))
	{
		$unit = strtolower(substr($mem_limit, -1, 1));
		$mem_limit = (int) $mem_limit;

		if ($unit == 'k')
		{
			$mem_limit = floor($mem_limit / 1024);
		}
		else if ($unit == 'g')
		{
			$mem_limit *= 1024;
		}
		else if (is_numeric($unit))
		{
			$mem_limit = floor((int) ($mem_limit . $unit) / 1048576);
		}
		$mem_limit = max(128, $mem_limit) . 'M';
	}
	else
	{
		$mem_limit = '128M';
	}
	@ini_set('memory_limit', $mem_limit);

	$errors = false;

	$db_tools = new \phpbb\db\tools\tools($db);

	// Get migrations schema
	$dir = '' . PHPBB_ROOT_PATH . 'ext';
	$files = $extensions = $vendors = array();
	$files = array_diff(scandir($dir), array('..', '.'));

	foreach($files as $key => $dir)
	{
		if (is_dir('' . PHPBB_ROOT_PATH . 'ext/' . $dir . ''))
		{
			$vendors[] = $dir;
			$extensions[$dir] = array_diff(scandir('' . PHPBB_ROOT_PATH . 'ext/' . $dir . ''), array('..', '.'));
		}
	}

	if (!empty($extensions))
	{
		foreach($extensions as $vendor => $ext)
		{
			foreach($ext as $key => $extension)
			{
				$ext_dir = '' . $phpbb_root_path . 'ext/' . $vendor . '/' . $extension . '/migrations/';
				$migrations = (@opendir($ext_dir)) ? array_diff(scandir($ext_dir), array('..', '.')) : array();
				$table_extra = $column_extra = $config_extra = $module_extra = $permissions_extra = array();
				foreach($migrations as $file)
				{
					$file = str_replace('.' . PHP_EXT . '', '', $file);
					$sub_dir = '' . $phpbb_root_path . 'ext/' . $vendor . '/' . $extension . '/migrations/' . $file . '';
					if (is_dir($sub_dir))
					{
						$migrations_subdir = (@opendir($sub_dir)) ? array_diff(scandir($sub_dir), array('..', '.')) : array();
						foreach($migrations_subdir as $key => $value)
						{
							$migrations[] = '' . $file . '\\' . $value . '';
						}
						$migrations = array_diff($migrations, array($file));
					}
				}

				foreach($migrations as $file)
				{
					$configs = $module_names = $permissions = array();
					$file = str_replace('.' . PHP_EXT . '', '', $file);
					$class = '' . $vendor . '\\' . $extension . '\\migrations\\' . $file . '';
					$phpbb_ext = new $class($config, $db, $db_tools, $table_prefix, $phpEx, $errors);
					if (!empty($phpbb_ext))
					{
						// Search tables used for extension
						$table_data = $phpbb_ext->revert_schema();
						if (isset($table_data['drop_tables']))
						{
							$table_extra = array_merge($table_extra, $table_data['drop_tables']);
						}
						if (isset($table_data['drop_columns']))
						{
							$column_extra = array_merge($column_extra, $table_data['drop_columns']);
						}

						$update_data = $phpbb_ext->update_data();
						foreach($update_data as $key => $value)
						{
							// Search config data
							if ($value[0] == 'config.add' || $value[0] == 'config.update')
							{
								$configs[] = $value[1][0];
							}
							// Search modules used for extension
							if($value[0] == 'module.add')
							{
								$ext_module_name = $value[1];
								$name = isset($ext_module_name[2]) ? $ext_module_name[2] :  '';
								if (is_array($name))
								{
									$module_names[] = (isset($name['module_langname'])) ? $name['module_langname'] : $ext_module_name[1];
								}
								else
								{
									$module_names[] = $name;
								}
							}
							// Search permissions used for extension
							if($value[0] == 'permission.add')
							{
								$permissions[] = $value[1][0];
							}
						}

						$configs = array_unique($configs);
						$config_extra = array_merge($config_extra, $configs);
						$module_extra = array_merge($module_extra, $module_names);
						$permissions_extra = array_merge($permissions_extra, $permissions);
						unset($phpbb_ext);
					}
				}

				$extra_data['tables'][$vendor][$extension] = $table_extra;
				$extra_data['colimns'][$vendor][$extension] = $column_extra;
				$extra_data['configs'][$vendor][$extension] = $config_extra;
				$extra_data['modules'][$vendor][$extension] = $module_extra;
				$extra_data['permissions'][$vendor][$extension] = $permissions_extra;
			}
		}
	}

	$cache->put('_stk_ext', $extra_data, 3600);
}

$info = $row = array();

if ($table)
{
	$info = (isset($extra_data['tables'])) ? finder($extra_data['tables'], $table) : '';
	$extra = (isset($info['data'])) ? '' . $table_prefix . '' . $info['data'] . '' : '' . $table_prefix . '' . $table. '';
	$template->assign_vars(array(
		'L_EXTRA_DATA_UNIT'		=> $lang['TABLE'],
		'L_EXTRA_DATA'			=> $lang['EXT_TABLE_FINDER'],
		'L_EXTRA_DATA_EXPLAIN'	=> $lang['EXT_TABLE_FINDER_EXPLAIN'],
	));
}
else if($column)
{
	$info = (isset($extra_data['colimns'])) ? finder($extra_data['colimns'], $column) : '';
	$extra = (isset($info['data'])) ? $info['data'] : $column;
	$template->assign_vars(array(
		'L_EXTRA_DATA_UNIT'		=> $lang['COLUMN'],
		'L_EXTRA_DATA'			=> $lang['EXT_COLUMN_FINDER'],
		'L_EXTRA_DATA_EXPLAIN'	=> $lang['EXT_COLUMN_FINDER_EXPLAIN'],
	));
}
else if($_config)
{
	$info = (isset($extra_data['configs'])) ? finder($extra_data['configs'], $_config) : '';
	$extra = (isset($info['data'])) ? $info['data'] : $_config;
	$template->assign_vars(array(
		'L_EXTRA_DATA_UNIT'		=> $lang['CONFIG'],
		'L_EXTRA_DATA'			=> $lang['EXT_CONFIG_FINDER'],
		'L_EXTRA_DATA_EXPLAIN'	=> $lang['EXT_CONFIG_FINDER_EXPLAIN'],
	));
}
else if($module)
{
	$info = (isset($extra_data['modules'])) ? finder($extra_data['modules'], $module) : '';
	$extra = (isset($info['data'])) ? $info['data'] : $module;
	$template->assign_vars(array(
		'L_EXTRA_DATA_UNIT'		=> $lang['MODULE'],
		'L_EXTRA_DATA'			=> $lang['EXT_MODULE_FINDER'],
		'L_EXTRA_DATA_EXPLAIN'	=> $lang['EXT_MODULE_FINDER_EXPLAIN'],
	));
}
else if($permission)
{
	$info = (isset($extra_data['permissions'])) ? finder($extra_data['permissions'], $permission) : '';
	$extra = (isset($info['data'])) ? $info['data'] : $permission;
	$template->assign_vars(array(
		'L_EXTRA_DATA_UNIT'		=> $lang['PERMISSION'],
		'L_EXTRA_DATA'			=> $lang['EXT_PERM_FINDER'],
		'L_EXTRA_DATA_EXPLAIN'	=> $lang['EXT_PERM_FINDER_EXPLAIN'],
	));
}

if($info)
{
	$path = 'ext/' . $info['vendor'] . '/' . $info['ext'] . '';
	if (file_exists('' . PHPBB_ROOT_PATH . '' . $path . '/composer.json'))
	{
		$buffer =  file_get_contents('' . PHPBB_ROOT_PATH . '' . $path . '/composer.json');
		if ($buffer)
		{
			$obj = json_decode($buffer);
			$display_name = $obj->{'extra'}->{'display-name'};
			$ext_path = $obj->{'name'};
			$version = $obj->{'version'};
			$description = $obj->{'description'};
		}
	}
	$sql = 'SELECT ext_active FROM ' . EXT_TABLE . '
		WHERE ext_name = \'' . $ext_path . '\'';
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	$color = ($row['ext_active']) ? '#282' : '#BC2A4D';
}

$template->assign_vars(array(
	'EXTRA_DATA'	=> (isset($extra)) ? $extra : '',
	'PATH'			=> (isset($info['ext'])) ? $path : '',
	'INFO'			=> (isset($info['ext'])) ? '<b style="color: ' . $color . '">' . $display_name . '</b>/' . $version . ' - ' . $description . '' : $lang['NOT_IN_EXT'],
));

// Output the main page
page_header($table);

$template->set_filenames(array(
	'body' => 'finder_body.html',
));

page_footer();

function finder($extra_data, $unit)
{
	global $table_prefix;

	$unit = str_replace($table_prefix, '', $unit); // If $unit is table we need remove table prefix from table name
	$extension = array();
	foreach($extra_data as $vendor => $exts)
	{
		foreach($exts as $ext_key => $extra)
		{
			foreach($extra as $dta)
			{
				if(is_array($dta))
				{
					if(in_array($unit, $dta))
					{
						$extension['vendor'] = $vendor;
						$extension['ext'] = $ext_key;
						$extension['data'] = $unit;
						return $extension;
					}
				}
				else
				{
					if ($unit == $dta)
					{
						$extension['vendor'] = $vendor;
						$extension['ext'] = $ext_key;
						$extension['data'] = $dta;
						return $extension;
					}
				}
			}
		}
	}
	return false;
}
