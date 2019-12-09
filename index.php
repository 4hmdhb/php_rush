<?php
	session_start();
	if (!isset($_SESSION['basket']))
		$_SESSION['basket'] = array();
	if (isset($_GET['add']))
		array_push(($_SESSION['basket']), $_GET['add']);
	if (isset($_GET['remove']))
		unset($_SESSION['basket'][array_search($_GET['remove'], $_SESSION['basket'])]);
	if (isset($_POST['checkout']) && $_POST['checkout'] === 'ok')
	{
		if (!isset($_SESSION['loggued_on_user']) || $_SESSION['loggued_on_user'] === '')
			header('location:auth/login.php');
		else if (!empty($_SESSION['basket']))
		{
			$order['client'] = $_SESSION['loggued_on_user'];
			$order['order'] = $_SESSION['basket'];
			$order['time'] = date('Y/m/d/h:i:s');
			$order['id'] = hash("whirlpool", $order['client'].$order['time']);
			$order['status'] = 'processing';
			if (file_exists('auth/private/orders'))
				$save_arr = unserialize(file_get_contents('auth/private/orders'));
			$save_arr[] = $order;
			file_put_contents('auth/private/orders', serialize($save_arr));
			echo "Order Placed";
			$_SESSION['basket'] = array();
			header("location: index.php");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Online Shop</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
	<?php if (isset($_SESSION["loggued_on_user"])) echo "Hello, ".$_SESSION["loggued_on_user"] ?>

	<form method="GET" action=""><button type="submit" name="add" value="cola" class="registerbtn">cola</button></form>
	<form method="GET" action=""><button type="submit" name="remove" value="cola" class="registerbtn">remove cola</button></form>
	<form method="GET" action=""><button type="submit" name="add" value="tea" class="registerbtn">tea</button></form>
	<form method="GET" action=""><button type="submit" name="remove" value="tea" class="registerbtn">remove tea</button></form>
	<form method="GET" action=""><button type="submit" name="add" value="coffee" class="registerbtn">coffee</button></form>
	<form method="GET" action=""><button type="submit" name="remove" value="coffee" class="registerbtn">remove coffee</button></form>
	<br>
	<form method="POST" action=""><button type="submit" name="checkout" value="ok" class="registerbtn">checkout</button></form>
	<form method="POST" action="auth/logout.php"><input type="submit" name="submit" value="logout"></form>
	<form method="POST" action="auth/delete.php"><input type="submit" name="submit" value="detele user"></form>

	<div class="dropdown">
		<button class="dropbtn">Basket</button>
		<div class="dropdown-content">
			<?php
				if (!empty($_SESSION['basket']))
				{
					$count = array_count_values($_SESSION['basket']);
					foreach ($count as $elem => $num) {
						echo "<a>$elem x $num</a>";
					}
				}
			?>
		</div>
	</div>
	
</body>
</html>