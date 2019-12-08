<?php
	function auth($login, $passwd)
	{
		if (!$login || !$passwd || !file_exists("private/passwd"))
			return false;
		$contents = unserialize(file_get_contents("private/passwd"));
		if (!$contents)
			return false; 
		foreach ($contents as $user) {
			if ($user["login"] === $login && $user["passwd"] === hash("whirlpool", $passwd))
				return true;
		}
		return false;
	}
?>