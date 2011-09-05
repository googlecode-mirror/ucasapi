<?php
if ( ! function_exists('database_error_msg'))
{
	function database_error_msg()
	{
		$CI =& get_instance();
		return $CI->config->item('database_error_msg');
	}
}

if ( ! function_exists('database_cn_error_msg'))
{
	function database_cn_error_msg()
	{
		$CI =& get_instance();
		return $CI->config->item('database_cn_error_msg');
	}
}
?>