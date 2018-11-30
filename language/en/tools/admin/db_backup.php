<?php
/**
 *
 * @package Support Toolkit - Database Backup English language Sheer
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
	'DB_BACKUP'					=> 'Database backup',
	'DB_BACKUP_EXPLAIN'			=> 'Here you can backup all your phpBB related data. You may store the resulting archive in your <samp>store/</samp> folder, download or see on screen. Depending on your server configuration you may be able to compress the file in a number of formats.',
	'DB_BACKUP_EXPLAIN_DUMPER'	=> 'The resulting backup is compatible with the format utility <a href ="http://www.mysqldumper.net/" target="_blank" /><strong>MySQLDumper</strong></a>, which supports granular recovery of database tables.',

	'SELECT_TABLE'		=> 'Tables',
	'MARK_ALL'			=> 'Select all',
	'EXPAND'			=> 'Expand',
	'COLLAPSE'			=> 'Collapse',
	'UNMARK_ALL'		=> 'Unmark all',
	'GZIP'				=> 'Compression',
	'SAVE'				=> 'Save on server',
	'DOWNLOAD'			=> 'Download',
	'BACKUP_SUCCESS'	=> 'The backup file has been created successfully.',
	'BACKUP_ACTION'		=> 'Action',
	'BACKUP_TYPE'		=> 'Backup type',
	'FULL'				=> 'Full',
	'STRUCTURE'			=> 'Structure only',
	'DATA'				=> 'Data only',
	'SCREEN'			=> 'Show on screen'
));
