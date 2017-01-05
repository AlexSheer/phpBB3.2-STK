<?php
/**
*
* @package Support Toolkit - Auto Cookies
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

class auto_cookies
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		global $config, $user, $request;

		$user->add_lang('acp/board');

		// Remove "www". Bug #62132
		$http_host = $request->server('HTTP_HOST');
		$server_name = $request->server('SERVER_NAME');
		$https = $request->server('HTTPS');
		$_domain = ((!empty($http_host)) ? htmlspecialchars(strtolower($http_host), ENT_COMPAT, 'UTF-8') : ((!empty($server_name)) ? htmlspecialchars($server_name, ENT_COMPAT, 'UTF-8') : htmlspecialchars(getenv('SERVER_NAME'), ENT_COMPAT, 'UTF-8')));
		$_domain = (strpos($_domain, 'www') === 0) ? substr($_domain, 3) : $_domain;

		return array(
			'title'	=> 'AUTO_COOKIES',
			'vars'	=> array(
				'legend1'				=> 'AUTO_COOKIES',
				'cookie_domain'			=> array('lang' => 'COOKIE_DOMAIN', 'type' => 'text:40:255', 'explain' => false, 'default' => $_domain),
				'cookie_name'			=> array('lang' => 'COOKIE_NAME', 'type' => 'text:40:255', 'explain' => false, 'default' => $config['cookie_name']),
				'cookie_path'			=> array('lang' => 'COOKIE_PATH', 'type' => 'text:40:255', 'explain' => false, 'default' => htmlspecialchars(substr($request->server('PHP_SELF'), 0, -13)), ENT_COMPAT, 'UTF-8'),
				'cookie_secure'			=> array('lang' => 'COOKIE_SECURE', 'type' => 'radio:disabled_enabled', 'explain' => true, 'default' => ((isset($https) && $https == 'on') ? true : false)),
			)
		);
	}

	/**
	* Run Tool
	*
	* Does the actual stuff we want the tool to do after submission
	*/
	function run_tool(&$error)
	{		global $config, $request;

		if (!check_form_key('auto_cookies'))
		{
			$error[] = 'FORM_INVALID';
			return;
		}

		$config->set('cookie_domain', $request->variable('cookie_domain', ''));
		$config->set('cookie_name', $request->variable('cookie_name', ''));
		$config->set('cookie_path', $request->variable('cookie_path', ''));
		$config->set('cookie_secure', $request->variable('cookie_secure', 0));

		trigger_error(user_lang('COOKIE_SETTINGS_UPDATED'));
	}
}
