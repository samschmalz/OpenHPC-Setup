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
		<label for="Master-name">Master Node Name</label>
		<input type="text" name="Master-name" value=<?php echo exec("hostname"); ?> required><br>	
		<label for="Master-ip">Master node IP</label>
		<input type="text" name="Master-ip" value=<?php echo exec("hostname -i"); ?> required><br>
		<br>
		<label for="compute-count"># of Compute Nodes</label>
		<input type="number" name="compute-count" id="compute-count" min="1" max="4" required><br>
		<p>
		IP Addresses:
		<div id="ip-block" style="padding-left: 50px">
			<label for="compute-ip-1">Compute Node 1</label>
			<input type="text" name="compute-ip-1"><br>
			<label for="compute-ip-2">Compute Node 2</label>
			<input type="text" name="compute-ip-2"><br>
			<label for="compute-ip-3">Compute Node 3</label>
			<input type="text" name="compute-ip-3"><br>
			<label for="compute-ip-4">Compute Node 4</label>
			<input type="text" name="compute-ip-4"><br>
		</div>
		</p>
		<p>
		MAC Addresses:
		<div id="mac-block" style="padding-left: 50px">
			<label for="compute-mac-1">Compute Node 1</label>
			<input type="text" name="compute-mac-1"><br>
			<label for="compute-mac-2">Compute Node 2</label>
			<input type="text" name="compute-mac-2"><br>
			<label for="compute-mac-3">Compute Node 3</label>
			<input type="text" name="compute-mac-3"><br>
			<label for="compute-mac-4">Compute Node 4</label>
			<input type="text" name="compute-mac-4"><br>
		</div>
		</p>
		<input type="submit" value="Submit">
	</form>
</body>
</html>

<!--<script>
	document.getElementById("compute-count").addEventListener("change", function(){
		document.getElementById("ip-block").forEach(console.log(this.nodeName));		
	});
</script>-->