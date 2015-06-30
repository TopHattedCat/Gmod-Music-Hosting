<?php
	require_once("utils.php");

	$sid = intval($_GET["steamid"]);

	$qry = Query("SELECT * FROM tracks WHERE steamid='$sid';");

	$arrayOfTracks = array();

	while ($row = mysqli_fetch_assoc($qry)) {
		$trackName = urldecode($row["name"]);

		$trackURL = $row["url"];

		$arrayToEnter = array();

		$arrayToEnter["name"] = $trackName;
		$arrayToEnter["url"] = $trackURL;

		$arrayOfTracks[] = $arrayToEnter;
	}

	echo(json_encode($arrayOfTracks));
?>