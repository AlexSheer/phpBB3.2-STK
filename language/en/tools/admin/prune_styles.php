<?php
/**
 *
 * @package Support Toolkit - Prune Styles English language Sheer
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
	'PRUNE_STYLES'				=> 'Checking style files',
	'PRUNE_STYLES_EXPLAIN'		=> 'This tool checks for the presence of the necessary components for all installed styles. If it finds that these components are missing, the style will be deleted. Continue?',
	'PRUNE_STYLES_SUCCESS'		=> 'Finished.',
	'STYLE_UNINSTALL_DEPENDENT'	=> 'Style "%s" cannot be uninstalled because it has one or more child styles.',
	'STYLE_UNINSTALL_SUCESS'	=> 'Style "%s" uninstalled successfully.',
	'PRUNE_STYLES_EMPTY'		=> 'No installed styles found with missing required components.',
));
