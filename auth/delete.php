<?php
	include("auth.php");
	session_start();
	delete($_SESSION['loggued_on_user']);
	$_SESSION['loggued_on_user'] = '';
	header("location:login.php");
?>