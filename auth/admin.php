<?php
	session_start();
	include("auth.php");
	if ($_SESSION['loggued_on_user'] !== 'admin')
		header("location: login.php");
	$message = "";
	if (isset($_POST['submit']) && $_POST['submit'] === 'add_product')
	{
		if (!add_products($_POST['name'], $_POST['category'], $_POST['price']))
			$message = "Product already exits";
	}
	if (isset($_POST['del_prod']))
	{
		remove_product($_POST['del_prod']);
		header("location: admin.php");
	}
	if (isset($_POST['delete']))
	{
		delete($_POST['delete']);
		header("location: admin.php");
	}
	if (isset($_POST['process']))
	{
		completed($_POST['process']);
		header("location: admin.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Page</title>
	<link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
	<h1>Orders</h1>
	<table>
		<tr class='color'>
			<th>Status</th>
			<th>User</th>
			<th>Basket</th>
			<th>Time</th>
		<tr>
		<?php
			if (file_exists('private/orders'))
			{
				$save_arr = unserialize(file_get_contents('private/orders'));
				if (!$save_arr)
					return ;
				$i = 0;
				foreach ($save_arr as $elem) {
					if (strcmp($elem['status'], 'processing') === 0)
						echo '<tr><th><form method="POST" action=""><button class="btn danger" type="submit" name="process" value="'.$elem['id'].'">Processing</button></form></th>';
					else
						echo "<tr><th><button class='btn success'>Completed</button></th>";
					echo '<th>'.$elem['client'].'</th><th>';
					$basket = array_count_values($elem['order']);
					foreach ($basket as $name => $num) {
						echo $name.': '.$num.', ';
					}
					echo '<th>'.$elem['time'].'</th></tr>';
				}
			}
		?>
	</table>

	<h1>Users</h1>
	<table>
		<?php
			if (file_exists('private/passwd'))
			{
				$users = unserialize(file_get_contents('private/passwd'));
				if (!$users)
					return ;
				foreach ($users as $elem) {
					$login = $elem['login'];
					if (strcmp($login, 'admin'))
					{
						echo "<tr><th>".$login."</th>";
						echo '<th><form method="POST" action=""><button class="btn danger"type="submit" name="delete" value="'.$login.'">Delete</button></form></th></tr>';
					}
				}
			}
		?>
	</table>

	<h1>Products</h1>
	<table>

		<tr class='color'>
			<th>Name</th>
			<th>Category</th>
			<th>Price</th>
			<th>Delete</th>
		<tr>
		<?php
			if (file_exists('private/products'))
			{
				$products = unserialize(file_get_contents('private/products'));
				if ($products)
				{
					foreach ($products as $elem) {
							echo "<tr><th>".$elem['name']."</th>";
							echo "<th>".$elem['category']."</th>";
							echo "<th>".$elem['price']."</th>";
							echo '<th><form method="POST" action=""><button class="btn danger"type="submit" name="del_prod" value="'.$elem['name'].'">Delete</button></form></th></tr>';
					
					}
				}
			}
		?>
	</table>

	<form action="" method="POST">
		<div class="container">
			<h1>Add Product</h1>
			<p><?php echo $message?></p>
			<hr>
			<label for="price"><b>Name</b></label>
			<input type="text" name="name" placeholder="Name" required="">

			<label for="price"><b>Category</b></label>
			<input type="text" name="category" placeholder="Category" required="">

			<label for="price"><b>Price</b></label>
			<input type="text" name="price" placeholder="Price" required="">
			<button type="submit" name="submit" value="add_product" class="registerbtn">Add</button>
		</div>	
	</form>
</body></html>
</body>
</html>