<?php
/**
 *
 * @package Support Toolkit - Prune Styles Russian language Sheer
 * @copyright (c) 2019 phpBBGuru Sheer
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
	'DELETE_BBCODE'						=> 'Removing bb-codes',
	'DELETE_BBCODE_PROGRESS'			=> 'Processed %1$d from %2$d ...',
	'DELETE_BBCODES'					=> 'Removing bb-codes in progress',
	'DELETE_BBCODE_COMPLETE'			=> 'Removing bb-codes completed.',
	'IDS_EMPTY'							=> 'You have not selected any bb-codes clearing mode. If you don\'t know how to choose a mode, check the box <strong>Cleaning BBCode everywhere</strong>. ',
	'DELETE_BBCODE_POST_IDS'			=> 'Perform removing bb-codes only among the listed messages',
	'DELETE_BBCODE_POST_IDS_EXPLAIN'	=> 'Specify post IDs in a comma-separated list (e.g. 1,2,3,5,8,13).',
	'DELETE_BBCODE_FORUMS'				=> 'Perform removing bb-codes only in selected forums',
	'DELETE_BBCODE_FORUMS_EXPLAIN'		=> 'To select multiple forums some or all of the proper use for your computer and browser combination of mouse and keyboard.',

	'DELETE_BBCODE_SELECT'				=> 'Select the desired bb-code',
	'DELETE_BBCODE_ALL'					=> 'Cleaning BBCode everywhere',
	'DELETE_BBCODE_ALL_EXPLAIN'			=> 'If checked, removal of BBCode will be done everywhere. This option will be ignored if specific posts or forums are specified above. Please note that this tool has the potential to damage your database beyond repair; therefore, <strong>be sure to backup your database before proceeding</strong>. Moreover, note that this tool may take some time to complete.',



));
