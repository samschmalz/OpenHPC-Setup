<?php
	session_start();

	if (isset($_POST)) {
		error_log(json_encode($_POST));
	}
?>

<body>
	Finishing up!
</body>
