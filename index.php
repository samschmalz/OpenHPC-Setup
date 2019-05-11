<?php
	session_start();

	if(isset($_POST)) {
		$pw1 = $_POST["password1"];
		$pw2 = $_POST["password2"];
		if (is_null($pw1) || is_null($pw2)) {
			$message = "Please fill both password fields.";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		elseif ($pw1 != $pw2) {
			$message = "Passwords do not match, please try again.";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		else {
			$message = "Thank you!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			header("Location: setup.php");
		}
	}
?>

<html>
	<head>
		<title>OpenHPC Password Change</title>
		<link rel="stylesheet" type="text/css" href="format.css">
	</head>
	<body>
		For security reasons, you should change the root password on your Raspberry Pi, as the default is well-known and insecure.<br>
		If you've already changed the password, great!  Just enter the same password here and it will "change" it to the same thing.<br>
		Otherwise, please enter your new password here.

		<form method="post" action="#">
			<label for="password1">Password:</label><br>
			<input type="password" name="password1" required><br>
			<label for="password2">Confirm:</label><br>
			<input type="password" name="password2" required><br>
			<input type="submit">
		</form>
	</body>
</html>