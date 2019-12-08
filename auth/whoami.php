<?php
	session_start();
	if ($_SESSION['loggued_on_user'] === NULL || $_SESSION['loggued_on_user'] === '')
		echo "Error\n";
	else
		echo $_SESSION['loggued_on_user']."\n";
?>