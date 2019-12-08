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
	
	function create($login, $passwd)
	{
		if ($login === '' || $passwd === '')
			return false;
		if (!file_exists("private"))
			mkdir ("private");
		if (file_exists("private/passwd"))
		{
			$save_arr = unserialize(file_get_contents("private/passwd"));
			foreach ($save_arr as $user) {
				if ($user["login"] === $login)
					return false;
			}
		}
		$tab["login"] = $login;
		$tab["passwd"] = hash('whirlpool', $passwd);
		$save_arr[] = $tab;
		file_put_contents("private/passwd", serialize($save_arr));
		return true;}

	function delete($login)
	{
		if (!$login || !file_exists("private/passwd"))
			return false;
		$contents = unserialize(file_get_contents("private/passwd"));
		if (!$contents)
			return false;
		$new_content;
		$i = 0;
		foreach ($contents as $user) {
			if ($user["login"] !== $login)
				$new_content[$i++] = $user;
		}
		file_put_contents("private/passwd", serialize($new_content));
		return true;
	}
?>