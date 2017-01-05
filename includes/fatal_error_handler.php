<?php
//
// phpBB NO White Pages
// v.0.0.1 20140216
// copyright (c) 2014 c61 http://c61.no-ip.org <c61@yandex.ru>
// license http://opensource.org/licenses/gpl-license.php GNU Public License
//

function fatal_error_handler_stk()
{
	if(function_exists('error_get_last'))
	{
		if($last_error = error_get_last())
		{
			switch ($last_error['type'])
			{
				case E_ERROR:
				case E_PARSE:
				case E_CORE_ERROR:
				case E_COMPILE_ERROR:
				case E_USER_ERROR:
				case E_RECOVERABLE_ERROR:
				{
					echo '<html><head></head><body><b style="color:#F00">Error ' . $last_error['type'] . ': ' . $last_error['message'] . ' at file ' . $last_error['file'] . ' line ' . $last_error['line'] . '</b><br /><br /></body></html>';
					break;
				}
				default:
				{
					break;
				}
			}
		}
	}
}

register_shutdown_function('fatal_error_handler_stk');
