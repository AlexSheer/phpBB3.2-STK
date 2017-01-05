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

class erk_files_repair
{
	function run()
	{
		global $config, $db;

		// Folders wich must contain file named .htaccess
		$paths_htaccess = array('', 'cache', 'config', $config['upload_path'], 'includes', 'store', $config['avatar_path']);

		// Folders wich must contain file named index.htm
		$paths_index = array('cache', 'download', 'ext', $config['upload_path'],
			$config['avatar_gallery_path'], 'images/avatars', 'store', $config['avatar_path'], 'images/icons',
			'images/icons/misc', 'images', 'images/ranks', 'includes', 'phpbb/auth', 'phpbb/auth/provider', 'phpbb/search', 'language'
		);

		// Find style components folders
		$styles_path = ''. PHPBB_ROOT_PATH .'styles/';
		$tyles = $this->find_style_dirs($styles_path);
		$styles_cheched_path = array();
		foreach($tyles as $style)
		{
			$styles_cheched_path[] =  'styles/' .$style. '/template';
			$styles_cheched_path[] =  'styles/' .$style. '/theme/images';
		}
		$paths_index = array_merge($paths_index, $styles_cheched_path);

		// Find installed language folders
		$lang_pahts = array();
		$sql = 'SELECT lang_dir FROM ' . LANG_TABLE;
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$lang_pahts[] = 'language/' . $row['lang_dir'] . '';
		}
		$db->sql_freeresult($result);

		$paths_index = array_merge($paths_index, $lang_pahts);

		// Find .htaccess
		$info = $this->find_file($paths_htaccess, '.htaccess');
		if(sizeof($info))
		{
			// Not found, try to repair
			$this->repair_file($info);
		}

		// Find index.htm
		$info = $this->find_file($paths_index, 'index.htm');

		if(sizeof($info))
		{
			// Not found, try to repair
			$this->repair_file($info);
		}

		return true;
	}

	/**
	 * Find specified file $searched_file in folders $paths
	 */
	function find_file($paths, $searched_file)
	{
		foreach($paths as $path)
		{
			$file_path = '' . PHPBB_ROOT_PATH . '' . $path . '/' . $searched_file . '';
			if (file_exists($file_path))
			{
				continue;
			}
			else
			{
				return $file_path;
			}
		}
		return array();
	}

	/**
	 * Find folders with phpBB styles components
	 */
	function find_style_dirs($styles_path)
	{
		$styles = array();
		$dp = @opendir($styles_path);
		if ($dp)
		{
			while (($file = readdir($dp)) !== false)
			{
				$dir = $styles_path . $file;
				if ($file[0] == '.' || !is_dir($dir))
				{
					continue;
				}

				if (file_exists("{$dir}/style.cfg"))
				{
					$styles[] = $file;
				}
			}
			closedir($dp);
		}

		return $styles;
	}

	/**
	 * Try to repair specified file $file
	 */
	function repair_file($file)
	{
		preg_match("#[^/]*$#i", $file, $match);

		if($match[0] === '.htaccess')
		{
			// .htaccess content
			$content = "<Files *>\n";
			$content .= "\tOrder Allow,Deny\n";
			$content .= "\tDeny from All\n";
			$content .= "</Files>\n";
		}
		else
		{
			// index.htm content
			$content = "<html>\n<head>\n<title></title>";
			$content .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
			$content .= "</head>\n\n<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n\n</body>\n</html>";
		}

		$written = true;

		//  Try open to write
		if (!($fp = @fopen($file, 'w')))
		{
			// Something went wrong
			$written = false;
		}

		// Try write content to file
		if (!(@fwrite($fp, $content)))
		{
			// Something went wrong
			$written = false;
		}

		// Close file
		@fclose($fp);

		if(!$written)
		{
			trigger_error('Cannot write file ' . $file . '');
		}

		return;
	}
}
