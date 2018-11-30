<?php
/**
 *
 * @package Support Toolkit - Reassign Thumbnails English language Sheer
 * @copyright (c) 2017 Sheer
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
	'REASSIGN_THUMBNAILS'			=> 'Rebuild thumbnails',
	'REASSIGN_THUMBNAILS_CONFIRM'	=> 'In case the option &laquo;Create thumbnails&nbsp; was disabled but attachments have been created, you can create thumbnails for such attachments.<br />Continue?',
	'REASSIGN_THUMBNAILS_PROGRESS'	=> 'Creatig thumbnails in progress. Do not interrupt the process!',
	'REASSIGN_THUMBNAILS_FINISHED'	=> 'Thumbnail creation complete.',
	'NO_THUMBNAILS_TO_REBUILD'		=> 'No files for which you need to create thumbnails.',
	'NEED_TO_PROCESS' 				=> 'Files without thumbnails: ',
	'THUMB'							=> '<strong>thumbnail</strong>',
	'REBUILT'						=> 'Create Thumbnails',
	'NO_NEED_REBUILT'				=> '<strong style="color: #aaa;">No need thumbnal</strong> for ',
	'SOURCE_UNAVAILABLE'			=> 'File not found: ',
	'NO_EXTENSIONS'					=> 'There are no file extensions for group extensions <strong>Images</ strong> .',
	'NO_EXTENSIONS_GROUP'			=> 'Еxtension group <strong>Images</ strong> does not exist.',
	'IMAGES'						=> 'Images',
));
