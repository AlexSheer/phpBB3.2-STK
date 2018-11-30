<?php
/**
*
* @package Support Toolkit - DB Optimizer English language Sheer
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
	'OPTIMIZE_TABLES'			=> 'DB tables optimization',
	'OPTIMIZE_TABLES_EXPLAIN'	=> 'Search the database tables that need defragmentation and optimization',
	'GO'						=> 'Optimize',
	'FRAGMENTED'				=> 'Fragmented',
	'CREATE_TIME'				=> 'Created',
	'UPDATE_TIME'				=> 'Latest update',
	'CHECK_TIME'				=> 'Verified',
	'NOT_FOUND' 				=> 'Tables requiring optimization is not detected',
	'TABLE_NAME'				=> 'Table',
	'TABLE_SIZE'				=> 'Used',
	'ALL'						=> 'Total: ',
	'SUCESS'					=> 'Selected tables were successfully optimized',
	'NOTHING'					=> 'Nothing selected',
	'OPTIMIZER_MESSAGE'			=> '<b>Caution!</b> Due to the large size of tables and strong fragmentation, the optimization process may take considerable time.<br />Please do not leave this page, do not wait until the results of the optimization.',
));
