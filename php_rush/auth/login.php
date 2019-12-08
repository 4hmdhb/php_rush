<?php
	include('auth.php');
	include('create.php');
	session_start();
	$message = "Please fill in this form to signin or signup.";
	if (isset($_POST['submit']))
	{
		if ($_POST['submit'] === 'signup')
		{
			if (create($_POST["login"], $_POST["passwd"]))
			{
				$_SESSION['loggued_on_user'] = $_POST["login"];
				header("location: ../index.php");
			}
			else
				$message = "<b class='red'>User already exists.</b>";
		}
		else if ($_POST['submit'] === 'signin')
		{
			if ($_POST['login'] === '' || $_POST['passwd'] === '')
				$message = "<b class='red'>Fields must be populated.</b>";
			else if (!auth($_POST['login'], $_POST['passwd']))
				$message = "<b class='red'>Incorrect login or password.</b>";
			else
			{
				$_SESSION['loggued_on_user'] = $_POST['login'];
				header("location: ../index.php");
			}
		}}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Online Shop</title>
	<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
	<form action="" method="POST">
		<div class="container">
			<h1>Log In</h1>
			<p><?php echo $message?></p>
			<hr>
			<label for="login"><b>Login</b></label>
			<input type="text" name="login" placeholder="inter your login" required="">

			<label for="passwd"><b>Password</b></label>
			<input type="password" name="passwd" placeholder="inter your password" required="">
			<button type="submit" name="submit" value="signin" class="registerbtn">Sign In</button>
			<button type="submit" name="submit" value="signup" class="registerbtn">Sign Up</button>
		</div>	
	</form>
</body>
</html>