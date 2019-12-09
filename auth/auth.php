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
		$new_content = array();
		$i = 0;
		foreach ($contents as $user) {
			if ($user["login"] !== $login)
				$new_content[$i++] = $user;
		}
		file_put_contents("private/passwd", serialize($new_content));
		return true;
	}
	function completed($id)
	{
		if (!$id || !file_exists("private/orders"))
			return false;
		$save_arr = unserialize(file_get_contents('private/orders'));
		$new_array = array();
		$i = 0;
		if (!$save_arr)
			return false;
		foreach ($save_arr as $order) {
			if (strcmp($order['id'], $id) === 0)
				$order['status'] = 'completed';
			$new_array[$i++] = $order;
		}
		file_put_contents("private/orders", serialize($new_array));
		return false;
	}
	function add_products($name, $category, $price)
	{
		if ($name === '' || $category === '' || $price === '')
			return false;
		if (!file_exists("private"))
			mkdir ("private");
		if (file_exists("private/products"))
		{
			$save_arr = unserialize(file_get_contents("private/products"));
			foreach ($save_arr as $product) {
				if ($product["name"] === $name)
					return false;
			}
		}
		$tab["name"] = $name;
		$tab["category"] = $category;
		$tab["price"] = $price;
		$save_arr[] = $tab;
		file_put_contents("private/products", serialize($save_arr));
		return true;		
	}
	function remove_product($name)
	{
		if (!$name || !file_exists("private/products"))
			return false;
		$contents = unserialize(file_get_contents("private/products"));
		if (!$contents)
			return false;
		$new_content = array();
		$i = 0;
		foreach ($contents as $user) {
			if ($user["name"] !== $name)
				$new_content[$i++] = $user;
		}
		file_put_contents("private/products", serialize($new_content));
		return true;
	}
?>