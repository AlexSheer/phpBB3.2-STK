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
		$author = $request->variable('developer', '');
		$version = $request->variable('version', '');
		$description = $request->variable('description', '');
		$homepage = $request->variable('homepage', '');
		$role = $request->variable('role', '');
		$display_name = $request->variable('display_name', '');

		$ext_name = $request->variable('ext_name', '');

		if($submit)
		{
			if(empty($vendor))
			{
				$error[] = $lang['EMPTY_VENDOR'];
			}
			if(strlen($vendor) < 3)
			{
				$error[] = $lang['VENDOR_NAME_TOO_SHORT'];
			}
			if(empty($ext_name))
			{
				$error[] = $lang['EMPTY_EXT_NAME'];
			}
			if(empty($author))
			{
				$error[] = $lang['EMPTY_AUTHOR'];
			}
			if(empty($display_name))
			{
				$error[] = $lang['EMPTY_DISPLAY_NAME'];
			}
			if(empty($version))
			{
				$error[] = $lang['EMPTY_VERSION'];
			}
			if(empty($error))
			{
				$ext_dir = '' . $phpbb_root_path . 'ext/' . $vendor;
				$handle = @opendir($ext_dir);
				$new_dir = '' . $ext_dir . '/' . $ext_name . '';
				if(!$handle)
				{
					mkdir($ext_dir);
				}
				if(@opendir($new_dir))
				{
					$error[] = $lang['ALREADY_EXISTS'];
				}
				if(empty($error))
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
					$data = "{\n    \"name\": \"" . $vendor . "/" . $ext_name . "\",\n";
					$data .= "    \"type\": \"phpbb-extension\",\n";
					$data .= ($description) ? "    \"description\": \"" . $description . "\",\n" : '';
					$data .= ($homepage) ? "    \"homepage\": \"" . $homepage . "\",\n" : '';
					$data .= "    \"version\": \"" . $version . "\",\n";
					$data .= "    \"time\": \"" . $user->format_date(time(), 'Y-m-d') . "\",\n";
					$data .= "    \"license\": \"GPL-2.0\",\n";
					$data .= "    \"authors\": [\n        {\n";
					$data .= "            \"name\": \"" . $author . "\"";
					$data .= ($homepage) ? ",\n            \"homepage\": \"" . $homepage . "\"" : '';
					$data .= ($role) ? ",\n            \"role\": \"" . $role . "\"" : '';
					$data .= "\n        }\n    ],\n    \"require\": {\n        \"php\": \">=5.3.3\"\n    },\n";
					$data .= "    \"require-dev\": {\n      \"phpbb/epv\": \"dev-master\"\n    },\n";
					$data .= "    \"extra\": {\n        \"display-name\": \"" . $display_name . "\",\n        \"soft-require\": {\n            \"phpbb/phpbb\": \"3.1.*@dev\"\n        }\n    }\n";
					$data .= "}\n";
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
					$data = "services:\n";
					$data .= "    " . $vendor . "." . $ext_name . ".listener:\n";
					$data .= "        class: " . $vendor . "\\" . $ext_name . "\\event\\listener\n";
					$data .= "        arguments:\n";
					$data .= "            - %core.root_path%\n";
					$data .= "            - @template\n";
					$data .= "        tags:\n";
					$data .= "            - { name: event.listener }\n";

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
					$data = "<?php\n/**\n*\n* @package phpBB Extension - " . $display_name . "\n* @copyright (c) " . date('Y') . " " . $author . "\n* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2\n*\n*/\n";
					$data .= "namespace " . $vendor . "\\" . $ext_name . "\\event;\n\n";
					$data .= "use Symfony\Component\EventDispatcher\EventSubscriberInterface;\n";
					$data .= "\n/**\n* Event listener\n*/\n";
					$data .= "class listener implements EventSubscriberInterface\n{\n";
					$data .= "/**\n* Assign functions defined in this class to event listeners in the core\n*\n* @return array\n* @static\n* @access public\n*/\n";
					$data .= "\tstatic public function getSubscribedEvents()\n\t{\n";
					$data .= "\t\treturn array(\n\t\t);\n\t}\n\n";
					$data .= "\t/** @var \phpbb\\template\\template */\n\tprotected $";
					$data .= "template;\n\n";
					$data .= "\t//** @var string phpbb_root_path */\n\tprotected $";
					$data .= "phpbb_root_path;\n\n";
					$data .= "\t/**\n\t* Constructor\n\t*/\n\tpublic function __construct($";
					$data .= "phpbb_root_path, \\phpbb\\template\\template $";
					$data .= "template)\n\t{\n\t\t$";
					$data .= "this->phpbb_root_path = $";
					$data .= "phpbb_root_path;\n\t\t$";
					$data .= "this->template = $";
					$data .= "template;\n\t}\n}\n";

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
					$data = "<?php\n/**\n*\n* @package phpBB Extension - " . $display_name . "\n* @copyright (c) " . date('Y') . " " . $author . "\n* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2\n*\n*/\n";
					$data .= "namespace " . $vendor . "\\" . $ext_name . "\migrations;\n\n";
					$data .= "class " . $ext_name . "_" . $vers . " extends \phpbb\db\migration\migration\n{\n\tpublic function effectively_installed()\n\t{\n\t\treturn;\n\t}\n\n";
					$data .= "\tstatic public function depends_on()\n\t{\n\t\treturn array('\phpbb\db\migration\data\\v310\dev');\n\t}\n\n";
					$data .= "\tpublic function update_schema()\n\t{\n\t\treturn array(\n\t\t);\n\t}\n\n";
					$data .= "\tpublic function revert_schema()\n\t{\n\t\treturn array(\n\t\t);\n\t}\n\n";
					$data .= "\tpublic function update_data()\n\t{\n\t\treturn array(\n\t\t\t// Current version\n\t\t\tarray('config.add', array('" . $ext_name . "_version', '" . $version . "')),\n\t\t);\n\t}\n}";

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
