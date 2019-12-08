<?php
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
?>