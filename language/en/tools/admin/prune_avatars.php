<?php
/**
 *
 * @package Support Toolkit - Prune Avatars English language Sheer
 * @copyright (c) 2009 phpBB Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
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
	'PRUNE_AVATARS'				=> 'Checking avatar files',
	'PRUNE_AVATARS_EXPLAIN'		=> 'This tool checks for the existence of extra avatars files (<em>files from avatars galleries are not checked</ em>). If these files exists, it will be removed. Continue?',
	'PRUNE_AVATARS_FINISHED'	=> 'Extra avatars files not found.',
	'PRUNE_AVATARS_PROGRESS'	=> 'Checking unnecessary files in progress. Do not interrupt the process!<br />The following files have been deleted:',
	'PRUNE_AVATARS_FAIL'		=> '<br />The following files could not be removed:',
));
