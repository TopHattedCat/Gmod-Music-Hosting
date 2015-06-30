<?php
	require("utils.php");
	require("steamauth/steamauth.php");

	if (isset($_SESSION["steamid"])) {
		$sid = $_SESSION["steamid"];
		$url = $_GET["url"];
		$checkIfIsOurs = Query("SELECT * FROM tracks WHERE steamid='$sid' AND url='$url';");

		$result = mysqli_fetch_assoc($checkIfIsOurs);

		if (isset($result["steamid"]) or ($_SESSION["steamid"] == "76561198013018913")) {
			unlink("/home/sam/sterling/upload/" . $url);
			Query("DELETE FROM tracks WHERE url='$url';");
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		} else {
			echo("You are attempting to delete a file that does not belong to you.");
		}
	} else {
		header("Location: http://the-sterling.co.uk/login.php");
	}