<?php
	require("steamauth/steamauth.php");
	if (isset($_SESSION["steamid"])) {
		header("Location: https://the-sterling.co.uk/index.php");
	}
	steamlogin_n();
?>
<html>
	<head>
		<link rel="stylesheet" href="login-css.css">
		<title>The Sterling Music Hosting</title>
	</head>
	<body>
		<br>
		<div class="banner-bar">
			<center>
				Welcome to the-sterling.co.uk
			</center>
		</div>
		<a href="/login.php?login">
			<div class="login-bar"><center>Sign in with <div class="img-block"><img height="65" width="65" src="steam.png"></div></center></div>

		</a>
	</body>
</html>
