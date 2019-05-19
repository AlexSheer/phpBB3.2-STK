<?php
/**
*
* @package Support Toolkit - extensions
* @version $Id$
* @copyright (c) 2010 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

class extensions
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		global $template, $lang, $db, $config, $phpbb_root_path, $request, $user;
		$error = array();
		$submit = $request->variable('sa', false);

		$vendor = $request->variable('vendor', '');
		$author = $request->variable('developer', '', true);
		$version = $request->variable('version', '');
		$description = $request->variable('description', '', true);
		$homepage = $request->variable('homepage', '');
		$role = $request->variable('role', '');
		$display_name = $request->variable('display_name', '', true);

		$ext_name = $request->variable('ext_name', '');

		if ($submit)
		{
			if(empty($vendor))
			{
				$error[] = $lang['EMPTY_VENDOR'];
			}
			if (strlen($vendor) < 3)
			{
				$error[] = $lang['VENDOR_NAME_TOO_SHORT'];
			}
			if (empty($ext_name))
			{
				$error[] = $lang['EMPTY_EXT_NAME'];
			}
			if (empty($author))
			{
				$error[] = $lang['EMPTY_AUTHOR'];
			}
			if(empty($display_name))
			{
				$error[] = $lang['EMPTY_DISPLAY_NAME'];
			}
			if (empty($version))
			{
				$error[] = $lang['EMPTY_VERSION'];
			}
			if (empty($error))
			{
				$ext_dir = '' . $phpbb_root_path . 'ext/' . $vendor;
				$handle = @opendir($ext_dir);
				$new_dir = '' . $ext_dir . '/' . $ext_name . '';
				if(!$handle)
				{
					mkdir($ext_dir);
				}
				if (@opendir($new_dir))
				{
					$error[] = $lang['ALREADY_EXISTS'];
				}
				if (empty($error))
				{
					mkdir($new_dir);
					mkdir('' . $new_dir . '/event');
					mkdir('' . $new_dir . '/config');
					mkdir('' . $new_dir . '/language');
					mkdir('' . $new_dir . '/language/en');
					mkdir('' . $new_dir . '/migrations');
					mkdir('' . $new_dir . '/styles');
					mkdir('' . $new_dir . '/styles/all');
					mkdir('' . $new_dir . '/styles/all/template');
					mkdir('' . $new_dir . '/styles/all/template/event');

					// Create composer.json
					$data = "{\r\n    \"name\": \"" . $vendor . "/" . $ext_name . "\",\r\n";
					$data .= "    \"type\": \"phpbb-extension\",\r\n";
					$data .= ($description) ? "    \"description\": \"" . $description . "\",\r\n" : '';
					$data .= ($homepage) ? "    \"homepage\": \"" . $homepage . "\",\r\n" : '';
					$data .= "    \"version\": \"" . $version . "\",\r\n";
					$data .= "    \"time\": \"" . $user->format_date(time(), 'Y-m-d') . "\",\r\n";
					$data .= "    \"license\": \"GPL-2.0\",\r\n";
					$data .= "    \"authors\": [\r\n        {\r\n";
					$data .= "            \"name\": \"" . $author . "\"";
					$data .= ($homepage) ? ",\r\n            \"homepage\": \"" . $homepage . "\"" : '';
					$data .= ($role) ? ",\r\n            \"role\": \"" . $role . "\"" : '';
					$data .= "\r\n        }\r\n    ],\r\n    \"require\": {\r\n        \"php\": \">=5.3.3\",\r\n        \"composer/installers\": \"~1.0\"\r\n    },\r\n";
					$data .= "    \"extra\": {\r\n        \"display-name\": \"" . $display_name . "\",\r\n        \"soft-require\": {\r\n            \"phpbb/phpbb\": \"3.2.0\"\r\n        }\r\n    }\r\n";
					$data .= "}\r\n";
					if (!($fp = fopen($new_dir . '/composer.json', 'w')))
					{
						// Something went wrong ... so let's try another method
						$written = false;
					}
					if (!(fwrite($fp, $data)))
					{
						// Something went wrong ... so let's try another method
						$written = false;
					}
					@fclose($fp);
					// Create services.yml
					$data = "services:\r\n";
					$data .= "    " . $vendor . "." . $ext_name . ".listener:\r\n";
					$data .= "        class: " . $vendor . "\\" . $ext_name . "\\event\\listener\r\n";
					$data .= "        arguments:\r\n";
					$data .= "            - '%core.root_path%'\r\n";
					$data .= "            - '@template'\r\n";
					$data .= "        tags:\r\n";
					$data .= "            - { name: event.listener }\r\n";

					if (!($fp = fopen($new_dir . '/config/services.yml', 'w')))
					{
						// Something went wrong ... so let's try another method
						$written = false;
					}
					if (!(fwrite($fp, $data)))
					{
						// Something went wrong ... so let's try another method
						$written = false;
					}
					@fclose($fp);
					// Create listener.php
					$data = "<?php\r\n/**\r\n*\r\n* @package phpBB Extension - " . $display_name . "\r\n* @copyright (c) " . date('Y') . " " . $author . "\r\n* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2\r\n*\r\n*/\r\n";
					$data .= "namespace " . $vendor . "\\" . $ext_name . "\\event;\r\n\r\n";
					$data .= "use Symfony\Component\EventDispatcher\EventSubscriberInterface;\r\n";
					$data .= "\r\n/**\r\n* Event listener\r\n*/\r\n";
					$data .= "class listener implements EventSubscriberInterface\r\n{\r\n";
					$data .= "/**\r\n* Assign functions defined in this class to event listeners in the core\r\n*\r\n* @return array\r\n* @static\r\n* @access public\r\n*/\r\n";
					$data .= "\tstatic public function getSubscribedEvents()\r\n\t{\r\n";
					$data .= "\t\treturn array(\r\n\t\t);\r\n\t}\r\n\r\n";
					$data .= "\t/** @var \phpbb\\template\\template */\r\n\tprotected $";
					$data .= "template;\r\n\r\n";
					$data .= "\t//** @var string phpbb_root_path */\r\n\tprotected $";
					$data .= "phpbb_root_path;\r\n\r\n";
					$data .= "\t/**\r\n\t* Constructor\r\n\t*/\r\n\tpublic function __construct($";
					$data .= "phpbb_root_path, \\phpbb\\template\\template $";
					$data .= "template)\r\n\t{\r\n\t\t$";
					$data .= "this->phpbb_root_path = $";
					$data .= "phpbb_root_path;\r\n\t\t$";
					$data .= "this->template = $";
					$data .= "template;\r\n\t}\r\n}\r\n";

					if (!($fp = fopen($new_dir . '/event/listener.php', 'w')))
					{
						// Something went wrong ... so let's try another method
						$written = false;
					}
					if (!(fwrite($fp, $data)))
					{
						// Something went wrong ... so let's try another method
						$written = false;
					}
					@fclose($fp);

					// Create migrations
					$vers = str_replace('.', '_', $version);
					$data = "<?php\r\n/**\r\n*\r\n* @package phpBB Extension - " . $display_name . "\r\n* @copyright (c) " . date('Y') . " " . $author . "\r\n* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2\r\n*\r\n*/\r\n";
					$data .= "namespace " . $vendor . "\\" . $ext_name . "\migrations;\r\n\r\n";
					$data .= "class " . $ext_name . "_" . $vers . " extends \phpbb\db\migration\migration\r\n{\r\n\tpublic function effectively_installed()\r\n\t{\r\n\t\treturn;\r\n\t}\r\n\r\n";
					$data .= "\tstatic public function depends_on()\r\n\t{\r\n\t\treturn array('\phpbb\db\migration\data\\v310\dev');\r\n\t}\r\n\r\n";
					$data .= "\tpublic function update_schema()\r\n\t{\r\n\t\treturn array(\r\n\t\t);\r\n\t}\r\n\r\n";
					$data .= "\tpublic function revert_schema()\r\n\t{\r\n\t\treturn array(\r\n\t\t);\r\n\t}\r\n\r\n";
					$data .= "\tpublic function update_data()\r\n\t{\r\n\t\treturn array(\r\n\t\t\t// Current version\r\n\t\t\tarray('config.add', array('" . $ext_name . "_version', '" . $version . "')),\r\n\t\t);\r\n\t}\r\n}";

					if (!($fp = fopen($new_dir . '/migrations/' . $ext_name . '_' . $vers . '.php', 'w')))
					{
						// Something went wrong ... so let's try another method
						$written = false;
					}
					if (!(fwrite($fp, $data)))
					{
						// Something went wrong ... so let's try another method
						$written = false;
					}
					@fclose($fp);

					meta_refresh(3, append_sid(STK_INDEX, array('c' => 'dev', 't' => 'extensions')));
					trigger_error(user_lang('SUCCESS'));
				}
			}
		}

		// This is kinda like the main page
		// Output the main page
		page_header($lang['SUPPORT_TOOL_KIT']);

		$template->assign_vars(array(
			'ERROR'				=> (sizeof($error)) ? implode('<br />', $error) : '',
			'VENDOR'			=> $vendor,
			'EXT_NAME'			=> $ext_name,
			'VERSION'			=> $version,
			'DESCRIPTION'		=> $description,
			'HOMEPAGE'			=> $homepage,
			'ROLE'				=> $role,
			'DISPLAY_NAME'		=> $display_name,
			'DEVELOPER'			=> $author,
			'U_DISPLAY_ACTION'	=> append_sid(STK_INDEX, array('c' => 'dev', 't' => 'extensions')),
		));

		$template->set_filenames(array(
			'body' => 'tools/extensions_body.html',
		));

		page_footer();
	}
}
