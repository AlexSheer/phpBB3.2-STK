<?php
/**
*
* @package Support Toolkit - Support Request Generator
* @version $Id$
* @copyright (c) 2009 phpBB Group
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

class srt_generator
{
	/**
	 * @var		Integer	The current step
	 * @access	public
	 */
	var $step = 0;

	/**
	 * The data array contains all data required to build the SRT questions,
	 * for each question the following keys can be used
	 * <code>
	 *		'name'			=>	Required, the identifier that is used for everything
	 *							(field names/langauge entries/etc)
	 *		'type'			=>	Required, the type of the input field. (dropdown ||
	 *							text || texteara || boolean)
	 *		'options'		=>	Only used when 'type' = dropdown. If set these
	 *							values are used as options for the dropdown box, if
	 *							not set the options will be red from the language files.
	 *		'p_callback'	=>	php callback. This function/method is called before
	 *							the question is added to the template. If the function
	 *							returns everything else than the boolean `false`
	 *							that value will be used as answer. If it returns
	 *							false (strict check) the question shall be displayed.
	 *		'hide'			=>	This question is only asked but will not be used
	 *							when compiling the SRT.
	 *		'depends'		=>	This question is only asked/handled if the given question
	 *							was answered with "true", this currently only supports
	 *							a boolean check.
	 * </code>
	 *
	 * @var		Array	The data that is used to generate the questions in the template
	 *					The array is prefilled with the main data which is filtered later
	 * @access	private
	 */
	var $_data = array();

	/**
	 * This method is always called, so we "abuse"
	 * it for this tool to setup some stuff we need
	 * later on.
	 */
	function tool_active()
	{
		global $config, $request;

		// This tool relies on the cache, if the user has the `NULL`
		// cache enabled he can't use this!
		global $acm_type;
		if ($acm_type == 'null')
		{
			return 'SRT_NO_CACHE';
		}

		// Set the step
		$this->step = $request->variable('step', 0);
		$reset = $request->variable('reset', false);
		if ($this->step < 0 || $this->step > 4 || !empty($reset))
		{
			$this->step = 0;
		}

		// Step one is something different, don't need any more
		if ($this->step == 0)
		{
			return true;
		}

		// Fill the data array
		$this->_data = array(
			'step2'	=> array(
				array(
					'name'			=> 'phpbb_version',
					'type'			=> 'dropdown',
					'options'		=> array(
						'phpBB ' . $config['version'],
						'phpBB ' . PHPBB_VERSION,
					),
					'p_callback'	=> array($this, '_prefill_phpbb_version'),
				),
				array(
					'name'			=> 'board_url',
					'type'			=> 'text',
					'p_callback'	=> 'generate_board_url',
				),
				array(
					'name'			=> 'dbms',
					'type'			=> 'text',
					'p_callback'	=> array($this, '_prefill_dbms'),
				),
				array(
					'name'			=> 'php',
					'type'			=> 'text',
					'p_callback'	=> PHP_VERSION,
				),
				array(
					'name'			=> 'gzip',
					'type'			=> 'text',
					'p_callback'	=> array($this, '_prefill_gzip'),
				),
				array(
					'name'			=> 'host_name',
					'type'			=> 'text',
				),
				array(
					'name'			=> 'install_type',
					'type'			=> 'dropdown',
				),
				array(
					'name'			=> 'inst_converse',
					'type'			=> 'dropdown',
				),
				array(
					'name'			=> 'mods_installed',
					'type'			=> 'boolean',
					'p_callback'	=> array($this, '_prefill_has_mods_installed'),
					'hide'			=> true,
				),
				array(
					'name'			=> 'registration_req',
					'type'			=> 'boolean',
					'hide'			=> true,
				),
			),
			'step3'	=> array(
				array(
					'name'			=> 'installed_mods',
					'type'			=> 'textarea',
					'depends'		=> 'mods_installed',
					'p_callback'	=> array($this, '_prefill_installed_mods'),
				),
				array(
					'name'			=> 'installed_styles',
					'type'			=> 'textarea',
					'p_callback'	=> array($this, '_prefill_installed_styles'),
				),
				array(
					'name'			=> 'installed_languages',
					'type'			=> 'textarea',
					'p_callback'	=> array($this, '_prefill_installed_languages'),
				),
				array(
					'name'			=> 'xp_level',
					'type'			=> 'dropdown',
				),
				array(
					'name'			=> 'test_username',
					'type'			=> 'text',
					'depends'		=> 'registration_req',
				),
				array(
					'name'			=> 'test_password',
					'type'			=> 'text',
					'depends'		=> 'registration_req',
				),
				array(
					'name'			=> 'problem_started',
					'type'			=> 'textarea',
				),
				array(
					'name'			=> 'problem_description',
					'type'			=> 'textarea',
				),
			),
		);

		// Have to return here otherwise shit breaks
		return true;
	}

	/**
	 * Generate all the Q/A pages
	 */
	function display_options()
	{
		global $cache, $template, $lang;

		if (@phpversion() >= '7.0.0')
		{
			$template->assign_var('S_PHP7', true);
		}

		// Step 0 is easy
		if ($this->step == 0)
		{
			return 'SRT_GENERATOR_LANDING';
		}

		// Step 1 only needs a single template var set
		if ($this->step == 1)
		{
			$template->assign_var('S_STEP1', true);
		}
		// Step 4 builds the result
		elseif ($this->step == 4)
		{
			$this->_build_srt();
		}
		// Got to do a bit more
		else
		{
			// Fetch the cached results, might need it here
			$_previous_data = $cache->get('_stk_srt_generator');

			// Run through the questions
			$_prefilled = array();
			foreach ($this->_data["step{$this->step}"] as $question)
			{
				// Some questions are only asked when certain answers are given earlier
				if (isset($question['depends']))
				{
					// Only support booleans atm
					if (empty($_previous_data[$question['depends']]))
					{
						continue;
					}
				}

				// First call the prefill if there is one
				$_p_callback_result = false;
				if (isset($question['p_callback']) && is_callable($question['p_callback']))
				{
					$_p_callback_result = call_user_func($question['p_callback']);
				}
				elseif (!empty($question['p_callback']))
				{
					$_p_callback_result = $question['p_callback'];
				}

				// If there is a prefill result use that as answer
				// Handle MODs a bit different (ugly :/)
				if ($_p_callback_result !== false && $question['name'] != 'installed_mods')
				{
					$_prefilled[$question['name']] = $_p_callback_result;
				}
				// Show the question in the template
				else
				{
					// If this is a dropdown generate the options.
					if ($question['type'] == 'dropdown')
					{
						// Options can be passed ether by an array in the data list or are generated from the language file
						$options = (!empty($question['options'])) ? $question['options'] : array();
						$this->_format_options($options, $question['name']);
					}

					$template->assign_block_vars('questionrow', array(
						'EXPLAIN'	=> (!empty($lang['SRT_QUESTIONS_EXPLAIN']["step{$this->step}"][$question['name']])) ? $lang['SRT_QUESTIONS_EXPLAIN']["step{$this->step}"][$question['name']] : '',
						'NAME'		=> $question['name'],
						'OPTIONS'	=> ($question['type'] == 'dropdown') ? $options : '',
						'PREFILL'	=> $_p_callback_result,
						'QUESTION'	=> $lang['SRT_QUESTIONS']["step{$this->step}"][$question['name']],
						'TYPE'		=> $question['type'],
					));
				}
			}
		}

		$template->assign_vars(array(
			'S_PREFILL'	=> (!empty($_prefilled)) ? htmlspecialchars(serialize($_prefilled)) : '',
			'U_ACTION'	=> append_sid(STK_INDEX, array('c' => 'main', 't' => 'srt_generator', 'step' => $this->step)),
		));

		// Spit out teh page
		page_header(user_lang('SRT_GENERATOR'));

		$template->set_filenames(array(
			'body' => 'tools/srt_generator.html',
		));

		page_footer();
	}

	/**
	 * Handle a submit
	 */
	function run_tool()
	{
		global $cache, $lang, $request;

		// Step 0 is a special place to be, only available for special people
		// this user isn't special so kick him to the user spot
		if ($this->step == 0)
		{
			// Distory the previous data
			$cache->destroy('_stk_srt_generator');
		}
		// In the first step only have to trigger errors
		else if ($this->step == 1)
		{
			global $template;

			// Disable the back link
			$template->assign_var('U_BACK_TOOL', false);

			$mod_related = $request->variable('mod_related', false);

			if (!empty($mod_related) && $mod_related == '1')
			{
				trigger_error($lang['STEP1_MOD_ERROR']);
			}

			$hacked = $request->variable('hacked', false);

			if (!empty($hacked) && $hacked == '1')
			{
				trigger_error($lang['STEP1_HACKED_ERROR']);
			}
		}

		// Handle the submitted stuf
		else
		{
			$_cached_data	= $cache->get('_stk_srt_generator');
			$_prefilled		= unserialize(htmlspecialchars_decode($request->variable('prefill', '', true)));

			// $_cached_data can be "false"
			if ($_cached_data === false)
			{
				$_cached_data = array();
			}

			// Run through the questions and fetch the answers
			$_answers = array();
			foreach ($this->_data["step{$this->step}"] as $question)
			{
				// From the prefill?
				if (isset($_prefilled[$question['name']]))
				{
					$_answers[$question['name']] = $_prefilled[$question['name']];
				}
				else
				{
					$_answers[$question['name']] = $request->variable($question['name'], '', true);
				}

				// For some types some aditional stuff is needed here
				switch ($question['type'])
				{
					case 'boolean'	:
						// When fetched from the form these are "yes" or "no",
						// convert to booleans
						if (in_array($_answers[$question['name']], array('yes', 'no')))
						{
							$_answers[$question['name']] = ($_answers[$question['name']] == 'yes') ? true : false;
						}
					break;

					case 'dropdown'	:
						// The correct one
						if (!empty($question['options']))
						{
							$_answers[$question['name']] = $question['options'][$_answers[$question['name']]];
						}
						else
						{
							$_answers[$question['name']] = $lang['SRT_DROPDOWN_OPTIONS']["step{$this->step}"][$question['name']][$_answers[$question['name']]];
						}
					break;
				}
			}

			// Place back in the cache
			$_cached_data = array_merge($_cached_data, $_answers);
			$cache->put('_stk_srt_generator', $_cached_data);
		}

		// Next one pleaze
		redirect(append_sid(STK_INDEX, array('c' => 'main', 't' => 'srt_generator', 'step' => ++$this->step)));
	}

	/**
	 * Build the SRT and output the result
	 *
	 * @return	void
	 * @access	private
	 */
	function _build_srt()
	{
		global $cache, $template, $lang, $user;

		$_template = array();

		// Get the submitted data
		$_answers = $cache->get('_stk_srt_generator');
		if ($_answers === false)
		{
			// Shouldn't happening in normal operation
			trigger_error('COULDNT_LOAD_SRT_ANSWERS');
		}

		// Header
		$_template[] = '[size=115][color=#368AD2][b]' . $lang['SRT_GENERATOR'] . '[/b][/color][/size]<br />';

		// Walk through the data
		foreach ($this->_data as $step => $questions)
		{
			// Do teh questions
			foreach ($questions as $question)
			{
				// Hidden?
				if (!empty($question['hide']))
				{
					continue;
				}

				$question_string = $lang['SRT_QUESTIONS'][$step][$question['name']];

				// No answer, easy :)
				if (empty($_answers[$question['name']]))
				{
					$_template[] = "[color=#cc6600][b]{$question_string}[/b][/color]: [i]" . $lang['NO_ANSVER'] . "[/i]";
					continue;
				}

				$_template[] = "[color=#cc6600][b]{$question_string}[/b][/color]: {$_answers[$question['name']]}";
			}
		}

		// Footer
		$_template[] = '<br />[size=80]' . $lang['BY_SRT_GENERATOR'] . '[/size]';

		// Output
		$user->add_lang('viewtopic');
		$template->assign_var('COMPILED_TEMPLATE', nl2br(implode('<br />', $_template)));
	}

	/**
	 * This method build the options for dropdown boxes, if the $options paramater
	 * contains a non-empty array the data within this array will be used for the
	 * options. If the array is empty the options will be fetched from the language
	 * files.
	 *
	 * @param	Array	$options	The array that will be used/filled with the
	 *								options for the dropdown box
	 * @param	String	$name		The name of the question, this is used to
	 *								lookup the correct strings in the language
	 *								files.
	 * @return	void
	 * @access	private
	 */
	function _format_options(&$options, $name = '')
	{
		global $lang;

		$_option_list = array();

		if (!empty($options))
		{
			foreach ($options as $_key => $_value)
			{
				$_option_list[] = "<option value='{$_key}'>{$_value}</option>";
			}
		}
		else
		{
			// If there is no language entry for this list return an empty array
			if (!empty($lang['SRT_DROPDOWN_OPTIONS']["step{$this->step}"][$name]))
			{
				foreach ($lang['SRT_DROPDOWN_OPTIONS']["step{$this->step}"][$name] as $_key => $_value)
				{
					$_option_list[] = "<option value='{$_key}'>{$_value}</option>";
				}
			}
		}

		// Set the return
		$options = implode('', $_option_list);
	}

	/**
	 * Some prefill methods
	 * @Note, due to strict checking if a prefill should return "false" you'll
	 * have to return the *string*, not the boolean!
	 */

	/**
	 * Just a wrapper to get the DBAL layer
	 */
	function _prefill_dbms()
	{
		global $db;

		return $db->sql_server_info();
	}

	/**
	 * Try to determine whether the user has EXTs installed.
	 */
	function _prefill_has_mods_installed()
	{
		global $db;

		$sql = 'SELECT ext_name
			FROM ' . EXT_TABLE;
		$result	= $db->sql_query_limit($sql, 1);
		$mod	= $db->sql_fetchfield('ext_name', false, $result);

		$db->sql_freeresult($result);

		if ($mod !== false)
		{
			return true;
		}
		return false;
	}

	/**
	 * Fetch all the installed languages from the database
	 *
	 * @return	String			All the languages installed on this board
	 * @access	private
	 */
	function _prefill_installed_languages()
	{
		global $db;

		$_languages = array();

		$sql = 'SELECT lang_local_name
			FROM ' . LANG_TABLE . '
			ORDER BY lang_local_name';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$_languages[] = $row['lang_local_name'];
		}

		$db->sql_freeresult($result);

		return implode("\n", $_languages);
	}

	function _prefill_installed_mods()
	{
		global $db;

		$_extensions = array();
		$dir = '' . PHPBB_ROOT_PATH . 'ext/';
		$sql = 'SELECT ext_name
			FROM ' . EXT_TABLE . '
			WHERE ext_active = 1';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$file = $dir . $row['ext_name'] . '/composer.json';
			$url = $this->get_ext_url($row['ext_name']);

			$_extensions[] = '' . $row['ext_name'] . ' (active) ' . '' . $url . '';
		}

		$sql = 'SELECT ext_name
			FROM ' . EXT_TABLE . '
			WHERE ext_active = 0';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$_extensions[] = '' . $row['ext_name'] . ' (disabled)';
		}

		$db->sql_freeresult($result);
		$ex = implode("\n", $_extensions);

		return implode("\n", $_extensions);
	}

	/**
	 * Fetch all the installed styles from the database
	 *
	 * @return	Boolean|String	False if for some reason no styles could be
	 *							red from the database. Otherwise the data
	 * @access	private
	 */
	function _prefill_installed_styles()
	{
		global $db, $config;

		$_styles = array();

		$sql = 'SELECT style_id, style_name, style_active
			FROM ' . STYLES_TABLE;
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$_styles[] = $row['style_name'] . (($row['style_active'] == 0) ? ' [i](not active)[/i]' : '') . (($row['style_id'] == $config['default_style']) ? ' [i](is default)[/i]' : '');
		}
		$db->sql_freeresult($result);

		return implode("\n", $_styles);
	}

	/**
	 * Test whether we can rely on the board to give us the version number
	 * This test fails if $config['version'] and PHPBB_VERSION differ.
	 *
	 * @return	Boolean|String	False if the version isn't relyable, otherwise
	 *							the version number.
	 * @access	private
	 */
	function _prefill_phpbb_version()
	{
		global $config, $lang;

		if (version_compare(strtolower($config['version']), strtolower(PHPBB_VERSION), 'eq'))	// use strtolower as my local php installation seems to think that x.y.z-PL1 != x.y.z-pl1
		{
			// Always point to the first option!
			return 0;
		}

		return false;
	}

	function _prefill_gzip()
	{
		global $config, $lang;

		return ($config['gzip_compress']) ? $lang['YES'] : $lang['NO'];

	}

	function get_ext_url($ext)
	{
		$url = false;
		$dir = '' . PHPBB_ROOT_PATH . 'ext/';
		$file = $dir . $ext . '/composer.json';
		if (file_exists($file))
		{
			$content = file_get_contents($file);
			if (preg_match('/"homepage": "(.*?)",/', $content, $matches))
			{
				$url = $matches[1];
			}
		}
		return $url;
	}
}
