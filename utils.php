<?php
	function Query($qryString) {
		$con = mysqli_connect("localhost", "username", "password", "music");

		$qry = mysqli_query($con, $qryString);

		mysqli_close($con);
		return $qry;
	}

	function CanUpload($sid) {
		$userQuery = Query("SELECT * FROM users WHERE steamid='$sid';");
		$trackCount = Query("SELECT COUNT(*) FROM tracks WHERE steamid='$sid';");

		$trackRes = mysqli_fetch_array($trackCount);
		$userRes = mysqli_fetch_assoc($userQuery);

		$amountHas = intval($trackRes[0]);
		$amountAllowed = intval($userRes["authorizedfor"]);

		if ($amountAllowed == -1) {
			return true;
		}

		if ($amountHas < $amountAllowed) {
			return true;
		} else {
			return false;
		}
	}
?>