<?php
	session_start();
?>

<html>
	<head>
		<title>OpenHPC Web Setup</title>
	</head>
	<body>
		<h1>Welcome to the OpenHPC Web Setup Utility!</h1>
		<?php
			$hostname = `hostname`;
			echo "Hostname: $hostname";
		?>

		<form method="post">
		</form>
	</body>
</html>
