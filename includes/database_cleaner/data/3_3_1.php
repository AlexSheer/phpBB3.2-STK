<?php
/**
*
* @package Support Toolkit - Database Cleaner
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

/**
* phpBB 3.3.1 data file
*/
class datafile_3_3_1
{
	/**
	* @var Array The bots
	*/
	var $bots = array(
		'DuckDuckGo [Bot]'	=> array('DuckDuckBot/', '')
	);

	/**
	* @var Array  3.3.1 config data
	*/
	var $config = array(
		'default_search_return_chars'		=> array('config_value' => '300', 'is_dynamic' => '0'),
		'display_unapproved_posts'			=> array('config_value' => '1', 'is_dynamic' => '0'),
		'recaptcha_v3_key'					=> array('config_value' => '', 'is_dynamic' => '0'),
		'recaptcha_v3_secret'				=> array('config_value' => '', 'is_dynamic' => '0'),
		'recaptcha_v3_domain'				=> array('config_value' => 'google.com', 'is_dynamic' => '0'),
		'recaptcha_v3_method'				=> array('config_value' => 'post', 'is_dynamic' => '0'),
		'recaptcha_v3_threshold_default'	=> array('config_value' => '0.5', 'is_dynamic' => '0'),
		'recaptcha_v3_threshold_register'	=> array('config_value' => '0.5', 'is_dynamic' => '0'),
		'recaptcha_v3_threshold_login'		=> array('config_value' => '0.5', 'is_dynamic' => '0'),
		'recaptcha_v3_threshold_post'		=> array('config_value' => '0.5', 'is_dynamic' => '0'),
		'recaptcha_v3_threshold_report'		=> array('config_value' => '0.5', 'is_dynamic' => '0'),
		'enable_queue_trigger'				=> array('config_value' => '0', 'is_dynamic' => '0'),
		'feed_overall_forums_limit'			=> array('config_value' => '15', 'is_dynamic' => '0'),
	);

	/**
	* @var Array Config entries that were removed by the 3.3.0 update
	*/
	var $removed_config = array(
		// No config entries removed  3.3.0 -> 3.3.1
	);

	/**
	* @var Array All default permission settings
	*/
	var $acl_options = array(
		// No permission changes 3.3.0 -> 3.3.1
	);

	/**
	* @var Array All default roles
	*/
	var $acl_roles = array(
		// No role changes  3.3.0 ->  3.3.1
	);

	/**
	* @var Array All default role data
	*/
	var $acl_role_data = array(
		// No role data changes  3.3.0 ->  3.3.1
	);

	/**
	* @var Array All default extension groups
	*/
	var $extension_groups = array(
		// No extension group changes  3.3.0 ->  3.3.1
	);

	/**
	* @var Array All default extensions
	*/
	var $extensions = array(
		// No extension changes  3.3.0 ->  3.3.1
	);

	/**
	* Define the module structure so that we can populate the database without
	* needing to hard-code module_id values
	*/
	var $module_categories = array(
		// No Module categories changes  3.3.0 ->  3.3.1
	);

	var $module_extras = array(
		// No Module extra changes  3.3.0 ->  3.3.1
	);

	var $module_categories_basenames = array(
		// No Categories basenames changes  3.3.0 ->  3.3.1
	);

	/**
	* @var Array All default groups
	*/
	var $groups = array(
		// No Group changes  3.3.0 ->  3.3.1
	);
	/**
	* @var Array All default report reasons
	*/
	var $report_reasons = array(
		// No reason changes  3.3.0 ->  3.3.1
	);

	var $acp_modules = array(
		// No ACP modules changes  3.3.0 ->  3.3.1
	);

	/**
	* Define the basic structure
	* The format:
	*		array('{TABLE_NAME}' => {TABLE_DATA})
	*		{TABLE_DATA}:
	*			COLUMNS = array({column_name} = array({column_type}, {default}, {auto_increment}))
	*			PRIMARY_KEY = {column_name(s)}
	*			KEYS = array({key_name} = array({key_type}, {column_name(s)})),
	*
	*	Column Types:
	*	INT:x		=> SIGNED int(x)
	*	BINT		=> BIGINT
	*	UINT		=> mediumint(8) UNSIGNED
	*	UINT:x		=> int(x) UNSIGNED
	*	TINT:x		=> tinyint(x)
	*	USINT		=> smallint(4) UNSIGNED (for _order columns)
	*	BOOL		=> tinyint(1) UNSIGNED
	*	VCHAR		=> varchar(255)
	*	CHAR:x		=> char(x)
	*	XSTEXT_UNI	=> text for storing 100 characters (topic_title for example)
	*	STEXT_UNI	=> text for storing 255 characters (normal input field with a max of 255 single-byte chars) - same as VCHAR_UNI
	*	TEXT_UNI	=> text for storing 3000 characters (short text, descriptions, comments, etc.)
	*	MTEXT_UNI	=> mediumtext (post text, large text)
	*	VCHAR:x		=> varchar(x)
	*	TIMESTAMP	=> int(11) UNSIGNED
	*	DECIMAL		=> decimal number (5,2)
	*	DECIMAL:	=> decimal number (x,2)
	*	PDECIMAL	=> precision decimal number (6,3)
	*	PDECIMAL:	=> precision decimal number (x,3)
	*	VCHAR_UNI	=> varchar(255) BINARY
	*	VCHAR_CI	=> varchar_ci for postgresql, others VCHAR
	*/
	function get_schema_struct(&$schema_data)
	{
		// Add table
		$schema_data['phpbb_notification_emails'] = array(
			'COLUMNS'		=> array(
				'notification_type_id'	=> array('USINT', 0),
				'item_id'				=> array('ULINT', 0),
				'item_parent_id'		=> array('ULINT', 0),
				'user_id'				=> array('ULINT', 0)
			),
			'PRIMARY_KEY'	=> array('notification_type_id', 'item_id', 'item_parent_id', 'user_id')
		);

		// Remove table
		unset($schema_data['phpbb_email_notifications']);
	}
}
