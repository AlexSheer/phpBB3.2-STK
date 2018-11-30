<?php
/**
*
* @package Support Toolkit - User Options English language Sheer
* @version $Id$
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'USER_OPTIONS'			=> 'Changing user options',
	'USER_OPTIONS_EXPLAIN'	=> 'Here you can change the user settings by default for all or selected user groups.<br />More detailed information can be obtained <a href="https://www.phpbb.com/support/docs/en/3.0/kb/article/changing-user-options-defaults-and-values/" target="_blank"><b>here</b></a>.',
	'NOTHING'				=> 'Do not change',
	'USER_OPTIONS_OK'		=> 'Users settings have been successfully changed.',

	'viewimg'				=> 'Display images within posts',
	'viewflash'				=> 'Display Flash animations',
	'viewsmilies'			=> 'Display smilies as images',
	'viewsigs'				=> 'Display signatures within posts',
	'viewavatars'			=> 'Display avatars within posts',
	'viewcensors'			=> 'Enable word censoring',
	'attachsig'				=> 'Attach signature by default',
	'bbcode'				=> 'Enable BBCode by default',
	'smilies'				=> 'Enable smilies by default',
	'sig_bbcode'			=> 'Enable BBCode within signature',
	'sig_smilies'			=> 'Display smilies as images within signature',
	'sig_links'				=> 'Convert the URL to links within signature',

	'ALL_GROUPS'			=> 'All Groups',
));
