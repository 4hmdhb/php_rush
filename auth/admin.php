<?php
	session_start();
	if ($_SESSION['loggued_on_user'] !== 'admin')
		header("location: login.php");
	include("auth.php");
	if (isset($_POST['delete']))
	{
		delete($_POST['delete']);
		header("location: basket.php");
	}
	if (isset($_POST['process']))
	{
		completed($_POST['process']);
		header("location: basket.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Page</title>
	<style>
		table {
		  border-collapse: collapse;
		  border-spacing: 0;
		  width: 100%;
		  border: 1px solid #ddd;
		}

		th, td {
		  text-align: left;
		  padding: 16px;
		}

		tr:nth-child(even){
		  background-color: #f2f2f2;
		}
		.color {
			background-color: #aaa;
		}
</style>
</head>
<body>
	<h2>Orders</h2>
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
						echo '<tr><th><form method="POST" action=""><button type="submit" name="process" value="'.$elem['id'].'">Processing</button></form></th>';
					else
						echo "<tr><th>Completed</th>";
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

	<h2>Users</h2>
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
						echo '<th><form method="POST" action=""><button type="submit" name="delete" value="'.$login.'">Delete</button></form></th></tr>';
					}
				}
			}
		?>
	</table>
</body>
</html>