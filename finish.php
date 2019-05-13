<?php
	session_start();

	if (!isset($_POST)) {
		echo "<script type='text/javascript'>alert('It doesn't look like you submitted anything, returning to previous page.');</script>";
		header("Location: setup.php");
	}

	//saving settings to file
	$hpc_settings = fopen("hpc_settings", "w");

	fwrite($hpc_settings, "SMS_NAME=" . $_POST["Master-name"]);
	fwrite($hpc_settings, "SMS_IP=" . $_POST["Master-ip"]);
	fwrite($hpc_settings, "SMS_ETH_INTERNAL=enp0s8");
	fwrite($hpc_settings, "INTERNAL_NETMASK=10.0.2.0/24");
	fwrite($hpc_settings, "NUM_COMPUTES=" . $_POST["compute-count"]);

	fclose($hpc_settings);

	exec("./setup.sh")
?>

<body>
	<div style="display:flex;justify-content:center;align-items:center;">Finishing up!</div>
</body>
