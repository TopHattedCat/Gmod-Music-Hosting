<?php
	require("utils.php");
	require("steamauth/steamauth.php");

	if ((isset($_SESSION["steamid"])) and ($_SESSION["steamid"] == "76561198013018913")) {
		$sid = $_POST["steamid"];
		$authFor = $_POST["authfor"];

		Query("INSERT INTO users (steamid, authorizedfor) VALUES ('$sid', '$authFor');");
	}

	header("Location: " . $_SERVER["HTTP_REFERER"]);
?>