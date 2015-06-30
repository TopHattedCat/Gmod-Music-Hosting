<?php

	

	function Convert($tempFileName, $fromType) {
		$converters = array();

		$converters["audio/x-flac"] = ".flac";
		$converters["audio/mp4a-latm"] = ".m4a";
		$converters["video/ogg"] = ".ogg";
		$converters["audio/ogg"] = ".ogg";
		$converters["application/ogg"] = ".ogg";
		$converters["audio/vnd.wave"] = ".wav";
		$converters["audio/wav"] = ".wav";
		$converters["audio/wave"] = ".wav";
		$converters["audio/x-wav"] = ".wav";
		$converters["audio/x-ms-wma"] = ".wma";
		
		if (!isset($converters[$fromType])) {
			return FALSE;
		}

		$fromFormat = $converters[$fromType];
		$uid = uniqid();
		$endFile = $uid . ".mp3";
		move_uploaded_file($tempFileName, "/home/sam/sterling/convert/" . $uid . $fromFormat);
		shell_exec("ffmpeg -i /home/sam/sterling/convert/" . $uid . $fromFormat . " /home/sam/sterling/upload/" . $uid . ".mp3");
		shell_exec("rm /home/sam/sterling/convert/" . $uid . $fromFormat);

		return $uid . ".mp3";
	}
?>