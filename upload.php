<?php

	require("utils.php");
	require("convert.php");
	require("steamauth/steamauth.php");

	if (isset($_SESSION["steamid"])) {
		if (CanUpload($_SESSION["steamid"])) {
			if (isset($_FILES["musicfile"])) {
				$type = $_FILES["musicfile"]["type"];

				$sid = $_SESSION["steamid"];
				$name = "";
	
				if ((isset($_POST["musicname"])) and (!($_POST["musicname"] == ""))) {
					$name = urlencode($_POST["musicname"]);
				} else {
					$name = "Untitled";
				}

				if (($type == "audio/mp3") or ($type == "audio/mpeg")) {
					$uid = uniqid();
					$url = $uid . ".mp3";
		
					move_uploaded_file($_FILES["musicfile"]["tmp_name"], "/home/sam/sterling/upload/" . $url);
					Query("INSERT INTO tracks (steamid, name, url) VALUES ('$sid', '$name', '$url');");
					header("Location: https://the-sterling.co.uk/index.php");
				} else {
					$converted = Convert($_FILES["musicfile"]["tmp_name"], $type);
					if ($converted == FALSE) {
						echo("You must upload an MP3, WAV, M4A, FLAC, OGG or WMA file. Go back and upload a compatible file instead of whatever you uploaded this time. You uploaded a " . $type);
					} else {
						Query("INSERT INTO tracks (steamid, name, url) VALUES ('$sid', '$name', '$converted');");
						header("Location: https://the-sterling.co.uk/index.php");
					}
					//header("Location: http://the-sterling.co.uk/index.php");
				}
			} else {
				echo("Upload error. Report to Top Hatted Cat. Here's some debug stuff: ");
				print_r($_FILES);
			}
		} else {
			echo("You have reached your upload quota. Please remove a track before attempting to add another.");
		}
	} else {
		header("Location: https://the-sterling.co.uk/login.php");
	}
?>