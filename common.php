<?php
/**
*
* @package Support Toolkit
* @copyright (c) 2010-2019 phpBB Group
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

// What version are we using?
define('STK_VERSION', '1.0.16-dev');
define('STK_QA', true);

define('ADMIN_START', true);

// This seems like a rather nasty thing to do, but the only places this IN_LOGIN is checked is in session.php when creating a session
// Reason for having it is that it allows us in the STK if we can not login and the board is disabled.
define('IN_LOGIN', true);

// Make that phpBB itself understands out paths
$phpbb_root_path = PHPBB_ROOT_PATH;
$phpEx = PHP_EXT;

// Prepare some vars
$stk_no_error = false;
define('PHPBB_MSG_HANDLER', 'stk_msg_handler');

// Include all common stuff
require(STK_ROOT_PATH . 'includes/functions.' . PHP_EXT);
require(STK_ROOT_PATH . 'includes/fatal_error_handler.' . PHP_EXT);
require(PHPBB_ROOT_PATH . 'common.' . PHP_EXT);
require(STK_ROOT_PATH . 'includes/plugin.' . PHP_EXT);
require STK_ROOT_PATH . 'includes/umil.' . PHP_EXT;

// phpBBs common.php registers hooks, these hooks tend to cause problems with the
// support toolkit. Therefore we unset the `$phpbb_hook` object here
unset($phpbb_hook);

// Disable event dispatcer.
// Some extensions can cause fatal errors, so all extensions should be disabled.
$phpbb_dispatcher->disable();

// When not in the ERK we setup the user at this point
// and load UML.
if (!defined('IN_ERK'))
{
	include STK_ROOT_PATH . 'includes/critical_repair.' . PHP_EXT;
	$critical_repair = new critical_repair();

	$user->session_begin();
	$auth->acl($user->data);
	if (!empty($user) && $user->data['user_id'] == ANONYMOUS && isset($config['default_lang']))
	{
		$user->data['user_lang'] = $config['default_lang'];
	}
	$user->setup('acp/common', $config['default_style']);

	$umil = new umil(true);
}

// Load STK config when not in the erk
if (!isset($stk_config))
{
	$stk_config = array();
	include STK_ROOT_PATH . 'config.' . PHP_EXT;
}

// Setup some common variables
$action = $request->variable('action', '');
$submit = $request->variable('submit', false);

// Try to determine the phpBB version number, we might need that down the road
// `PHPBB_VERSION` was added in 3.0.3, for older versions just rely on the config
if (!defined('IN_ERK') && (defined('PHPBB_VERSION') && PHPBB_VERSION == $config['version']) || !defined('PHPBB_VERSION'))
{
	define('PHPBB_VERSION_NUMBER', $config['version']);
	stk_add_lang('common');
	// Try to determine the phpBB actually version number
	$updates_available = false;
	$version_helper = $phpbb_container->get('version_helper');
	try
	{
		$updates_available = $version_helper->get_suggested_updates(false);
	}
	catch (\RuntimeException $e)
	{
		$template->assign_vars(array(
			'S_VERSIONCHECK_FAIL'		=> true,
			'VERSIONCHECK_FAIL_REASON'	=> $user->lang('VERSIONCHECK_FAIL'),
		));
	}
	if ($updates_available)
	{
		check_phpbb_version();
	}
}
// Cant correctly determine the version, let the user define it.
// As the `perform_unauthed_quick_tasks` function is used skip this
// if there is already an action to be performed.
else if ($action != 'genpasswdfile' || $action != 'downpasswdfile' || $action != 'stklogout' || $action != 'request_phpbb_version')
{
	$action = 'request_phpbb_version';
}
