<?php
/**
*
* @package Support Toolkit - Set prosilver as default style English language Sheer
* @version $Id$
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
	'SET_PROSILVER'						=> 'Assigning prosilver to the default style',
	'SET_PROSILVER_CONFIRM'				=> 'Allows set Prosilver and assign it as the default style for all users.',
	'SET_PROSILVER_ALLREADY_ASSIGNED'	=> 'Prosilver is already assigned as the default style. No action is taken.',
	'SET_PROSILVER_ACTIVATED'			=> 'Prosilver was successfully activated.',
	'SET_PROSILVER_RESET'				=> 'Prosilver was assigned as the default style.',
	'SET_PROSILVER_DOES_NOT_EXIST'		=> 'Prosilver does not exist. Please upload a copy of prosilver from the <a href="https://www.phpbb.com/downloads/">3.2.1 Full Package</a>.',
));
