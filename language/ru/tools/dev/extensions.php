<?php
/**
*
* @package Support Toolkit - phpbb Russian language Sheer
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

/**
* DO NOT CHANGE
*/
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
	'EXTENSIONS'			=> 'Разработка расширений',
	'EXTENSIONS_EXPLAIN'	=> 'Создание заготовки расширения. После выполнения необходимых действий будет создана минимальная структура расширения. Для создания полноценного расширения вам потребуется отредактировать сгенерированные файлы и добавить новые, которые потребуются для работы расширения.',
	'DEVELOPER'				=> 'Имя (ник) разработчика',
	'DEVELOPER_EXPLAIN'		=> 'Это имя разработчика расширения, которое будет отображаться в администраторском разделе во вкладке <strong>&laquo;Персонализация-->Управление расширениями-->Информация о расширении&raquo;</strong> вместе с остальными дополнительными параметрами, которые вы можете ввести ниже.',
	'AUTHOR_EXPLAIN'		=> 'Имя вендора.<br />В папке ./ext/ будет создана папка (если таковой еще не существует) с именем, совпадающим с этим параметром. Все расширения этого автора должны находиться внутри этой папки. В названиях папок не допускаются тире и знаки подчёркивания. В имени вендора должно быть не менее 3-х символов.',
	'EXT_EXPLAIN'			=> 'Название расширения.<br />В папке ./ext/_имя_вендора_/ будет создана папка с именем, совпадающим с этим параметром. Все папки и файлы данного расширения будут располагаться внутри этой папки. В названии расширения должно быть не менее 3-х символов.',
	'DISPLAY_NAME'			=> 'Отображаемое название расширения',
	'DESCRIPTION'			=> 'Описание',
	'VERSION'				=> 'Версия расширения',
	'DESCRIPTION_EXPLAIN'	=> 'Краткое описание расширения.',
	'ROLE'					=> 'Роль разработчика',
	'ROLE_EXPLAIN'			=> 'Краткое описание вклада автора в разработку расширения.',
	'HOMEPAGE'				=> 'Адрес сайта разработчика',

	'EMPTY_VENDOR'			=> 'Не указано имя вендора',
	'EMPTY_EXT_NAME'		=> 'Не указано название расширения',
	'EMPTY_AUTHOR'			=> 'Не указано имя (ник) разработчика',
	'EMPTY_DISPLAY_NAME'	=> 'Не указано отображаемое имя расширения',
	'EMPTY_VERSION'			=> 'Не указана версия расширения',
	'VENDOR_NAME_TOO_SHORT'	=> 'В имени вендора должно быть не менее 3-х символов.',
	'EXT_NAME_TOO_SHORT'	=> 'В названии расширения должно быть не менее 3-х символов.',

	'ARE_REQUIRED'			=> '<hr>Поля, отмеченные * обязательны для заполнения.',
	'SUCCESS'				=> 'Заготовка расширения успешно создана. Теперь вы можете начать непосредственное создание расширения.',
	'ALREADY_EXISTS'		=> 'Такое расширение уже существует!',
));
