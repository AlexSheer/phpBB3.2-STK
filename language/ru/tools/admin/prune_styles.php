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
	'PRUNE_STYLES'				=> 'Проверка файлов стилей',
	'PRUNE_STYLES_EXPLAIN'		=> 'Данный инструмент проверяет наличие необходимых компонентов для всех установленных стилей. Если будет обнаружено, что эти компоненты отсутствуют, стиль будет удален. Продолжить?',
	'PRUNE_STYLES_SUCCESS'		=> 'Инструмент проверки закончил свою работу.',
	'STYLE_UNINSTALL_DEPENDENT'	=> 'Стиль «%s» не может быть удалён, так как является родительским для других стилей.',
	'STYLE_UNINSTALL_SUCESS'	=> 'Стиль «%s» был успешно удалён из Базы Данных.',
	'PRUNE_STYLES_EMPTY'		=> 'Не найдено установленных стилей с отсутствующими необходимыми компонентами.',
));
