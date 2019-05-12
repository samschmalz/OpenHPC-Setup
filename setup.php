<?php
	session_start();
	if (!isset($_SESSION["arch"]))
	{
		$_SESSION['arch'] = `uname -p`;
	}

	if (isset($_POST)) {
		error_log(json_encode($_POST));
	}

	//getting IP addresses
	$arpfile = fopen("../arp-results.txt", "r");
	$arpcount = exec("wc -l ../arp-results.txt");
	$arp_values = array();
	for ($i = 0; $i < $arpcount; $i++) {
		$arp_values[$i] = fgets($arpfile);
	}
	fclose($arpfile);

	//getting MAC addresses
	$macfile = fopen("../map-results.txt", "r");
	$maccount = exec("wc -l ../mac-results.txt");
	$mac_values = array();
	for ($i = 0; $i < $maccount; $i++) {
		$mac_values[$i] = fgets($macfile);
	}
	fclose($macfile);
?>

<html>
	<head>
		<title>OpenHPC Setup</title>
		<link rel="stylesheet" type="text/css" href="format.css">
		<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	</head>
<body onload="SetDefaults()">
	<h1>OpenHPC Setup Page</h1>
	<form method="post" action="finish.php">
		<label for="Architecture">CPU Architecture</label>
		<button type="button" onclick="ArchDesc()">?</button>
		<input type="text" name="Architecture" value=<?php echo $_SESSION['arch']; ?> required><br>
		<label for="Master-name">Master Node Name</label>
		<input type="text" name="Master-name" value=<?php echo exec("hostname"); ?> required><br>	
		<label for="Master-ip">Master node IP</label>
		<input type="text" name="Master-ip" value=<?php echo exec("hostname -i"); ?> required><br>
		<label for="compute-count"># of Compute Nodes</label>
		<input type="number" name="compute-count" id="compute-count" min="1" max="4" required><br>
		<label for="compute-prefix">Prefix for Compute Nodes</label>
		<button type="button" onclick="PrefixDesc()">?</button>
		<input type="text" name="compute-prefix" id="compute-prefix"><br>
		<p>
			<h3>Compute Node Names:</h3>
			<div id="name-block" style="padding-left: 50px">
				<label for="compute-name-1">Compute Node 1</label>
				<input type="text" name="compute-name-1"><br>
				<label for="compute-name-2">Compute Node 2</label>
				<input type="text" name="compute-name-2"><br>
				<label for="compute-name-3">Compute Node 3</label>
				<input type="text" name="compute-name-3"><br>
				<label for="compute-name-4">Compute Node 4</label>
				<input type="text" name="compute-name-4"><br>
			</div>
		</p>
		<p>
			<h3>IP Addresses:</h3>
			<div id="ip-block" style="padding-left: 50px">
				<label for="compute-ip-1">Compute Node 1</label>
				<input type="text" name="compute-ip-1" value=<?php echo $arp_values[0] ?>><br>
				<label for="compute-ip-2">Compute Node 2</label>
				<input type="text" name="compute-ip-2" value=<?php echo $arp_values[1] ?>><br>
				<label for="compute-ip-3">Compute Node 3</label>
				<input type="text" name="compute-ip-3" value=<?php echo $arp_values[2] ?>><br>
				<label for="compute-ip-4">Compute Node 4</label>
				<input type="text" name="compute-ip-4" value=<?php echo $arp_values[3] ?>><br>
			</div>
		</p>
		<p>
			<h3>MAC Addresses:</h3>
			<div id="mac-block" style="padding-left: 50px">
				<label for="compute-mac-1">Compute Node 1</label>
				<input type="text" name="compute-mac-1" value=<?php echo $mac_values[0] ?>><br>
				<label for="compute-mac-2">Compute Node 2</label>
				<input type="text" name="compute-mac-2" value=<?php echo $mac_values[1] ?>><br>
				<label for="compute-mac-3">Compute Node 3</label>
				<input type="text" name="compute-mac-3" value=<?php echo $mac_values[2] ?>><br>
				<label for="compute-mac-4">Compute Node 4</label>
				<input type="text" name="compute-mac-4" value=<?php echo $mac_values[3] ?>><br>
			</div>
		</p>
		<input type="submit" value="Submit">
	</form>
</body>
</html>

<script>
	function PrefixDesc() {
		let desc = "This is a piece of text that will be the same across all compute nodes.\nFor example, if you have CNode1, CNode2, and CNode3, this would be 'CNode'";
		alert(desc);
	}
	function ArchDesc() {
		let desc = "This is the CPU Type of your head node, which should be the same as the\ncompute nodes. If you don't know what this should be, then leave it as its\ndefault value.";
		alert(desc);
	}
	/*document.getElementById("compute-count").addEventListener("change", function(){
		alert("Hello");
	});*/
	document.getElementById("compute-prefix").addEventListener("change", function(){
		var prefix = document.getElementById("compute-prefix").value;
		for (var i = 1; i < 5; i++) {
			let id_string = "compute-name-" + i;
			let tempval = document.getElementById(id_string).value;
			document.getElementById(id_string).value = prefix+tempval;
		}
	});

</script>
