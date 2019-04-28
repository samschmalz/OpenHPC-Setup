<?php
	session_start();
	if (!isset($_SESSION["arch"]))
	{
		$_SESSION['arch'] = `uname -p`;
	}

	if (isset($_POST)) {
		error_log(json_encode($_POST));
	}
?>

<html>
<head>
	<title>OpenHPC Setup</title>
</head>
<body>
	<form method="post" action="finish.php">
		<label for="Architecture">CPU Architecture</label>
		<input type="text" name="Architecture" value=<?php echo $_SESSION['arch']; ?> required><br>
		<label for="compute-count"># of Compute Nodes</label>
		<input type="number" name="compute-count" min="1" max="4" required><br>
		<div style="padding-left: 50px">
			IP Addresses:<br>
			<label for="compute-ip-1">Compute Node 1</label>
			<input type="text" name="compute-ip-1"><br>
			<label for="compute-ip-2">Compute Node 2</label>
			<input type="text" name="compute-ip-2"><br>
			<label for="compute-ip-3">Compute Node 3</label>
			<input type="text" name="compute-ip-3"><br>
			<label for="compute-ip-4">Compute Node 4</label>
			<input type="text" name="compute-ip-4"><br>
		</div>
		Other stuff
		<input type="submit" value="Submit">
	</form>
</body>
</html>
