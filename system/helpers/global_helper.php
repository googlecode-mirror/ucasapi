<?php
if ( ! function_exists('database_eror_msg'))
{
	function database_eror_msg()
	{
		$CI =& get_instance();
		return $CI->config->item('database_eror_msg');
	}
}
?>