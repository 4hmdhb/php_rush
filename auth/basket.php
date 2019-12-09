<?php
	session_start();
	if (file_exists('private/orders'))
	{
		$save_arr = unserialize(file_get_contents('private/orders'));
		print_r($save_arr);
	}
?>