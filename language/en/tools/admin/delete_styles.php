<?php
/**
 *
 * @package Support Toolkit - Delete Styles English language Sheer
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
	'DELETE_STYLES'				=> 'Removing custom styles',
	'DELETE_STYLES_EXPLAIN'		=> 'All custom styles will be deleted. The standard <em> prosilver </em> style will be install if it has not been installed or removed before, and will also be set as default style for conference and for all users.. Продолжить?',
	'NOT_EXISTS_ PROSILVER'		=> 'There are no <em> prosilver </em> style files. You must copy the <em> prosilver </em> folder from the installation package to the <em> styles </em> folder.',
	'STYLE_UNINSTALL_SUCESS'	=> 'Style «%s» was successfully removed from the Database.',
	'DELETE_STYLES_EMPTY'		=> 'No installed custom styles found.',
));
