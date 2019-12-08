<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Online Shop</title>
</head>
<body>
	Hello, <?php if (isset($_SESSION["loggued_on_user"])) echo $_SESSION["loggued_on_user"] ?>
	<form method="POST" action="auth/logout.php"><input type="submit" name="submit" value="logout"></form>
	<form method="POST" action="auth/delete.php"><input type="submit" name="submit" value="detele user"></form>
	
</body>
</html>