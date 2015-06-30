<?php
	require("steamauth/steamauth.php");
	require("utils.php");

	$allowedTracks = 5;
	$newUser = FALSE;

	if (!isset($_SESSION["steamid"])) {
		header("Location: https://the-sterling.co.uk/login.php");
	} else {
		$sid = $_SESSION["steamid"];
		$qry = Query("SELECT * FROM users WHERE steamid='$sid';");

		$res = mysqli_fetch_assoc($qry);

		if (!isset($res["steamid"])) {
			Query("INSERT INTO users (steamid, authorizedfor) VALUES ('$sid', '15')");
			$newUser = TRUE;
			$allowedTracks = 15;
		} else {
			if (intval($res["authorizedfor"]) == -1) {
				$allowedTracks = "&infin;";
			} else {
				$allowedTracks = $res["authorizedfor"];
			}
		}
	}


	$adminMode = FALSE;
	if (($sid == "76561198013018913") and ($_GET["all"] == "yes")) {
		$adminMode = TRUE;
	}

	$isTHC = FALSE;
	if ($sid == "76561198013018913") {
		$isTHC = TRUE;
	}

	$geo = FALSE;

	if ($_SERVER["HTTP_CF_IPCOUNTRY"] == "GB") {
		$geo = TRUE;
	}
?>
<html>
	<head>
		<title>The Sterling Music Hosting<?php if ($adminMode) { echo(" - Administration"); }?></title>
		<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="bootstrap.min.css">
		<style>
			body
			{
				padding-left: 5px;
			}
		</style>
	</head>
	<body>
		<center>
			<h1>The Sterling Music Hosting<?php if ($adminMode) { echo(" - Administration"); }?></h1>
			<?php if ($adminMode) { echo("<h2>Showing ALL tracks | <span style='color: red'>Track removal is unrestriced</span></h2>"); } ?>
			<?php if (($isTHC) and (!$adminMode)) { echo("<a class='btn btn-success' href='index.php?all=yes'>Administration Mode</a>"); } ?>
			<?php if ($adminMode) { echo("<a class='btn btn-danger' href='index.php'>Normal Mode</a>"); } ?>
		</center>
		<h2>Upload</h2>
		<form action="upload.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
			<input type="file" name="musicfile"><br>
			<input class="form-control" style="width: 250px;" placeholder="Track Name" type="text" name="musicname"><br><br>
			<input class="btn btn-primary" type="submit" name="musicSubmit" value="Upload">
		</form>
		<?php
			if ($adminMode) {
				require("whitelist-form.php");
			}
		?>
		<br>
		<?php if ($newUser) { echo("<p class='lead' style='color: rgb(30, 130, 76);'>Welcome to the-sterling.co.uk! From here, you can upload music to easily play on HRP without copying over URLs. Just upload a track and hit R when in-game and looking at a radio to get started.</p>"); } ?>
		<h2>Current songs</h2>
		<h3>You are currently allowed <?php echo($allowedTracks); ?> tracks.</h3>
		<p class="lead">Please keep tracks around 5MB or below. Max file size is 16MB.</p>
		<p class="lead">Hit R when looking at a radio to open a menu containing your tracks so you don't have to copy the URL over.</p>
		<table class="table">
			<tr>
				<th>Name</th>
				<?php if ($geo) { echo("<th>URL</th>"); } ?>
				<th></th>
				<?php
					if ($adminMode) {
						echo("<th>Owner's SteamID</th>");
					}
				?>
			</tr>
			<?php
				$sid = $_SESSION["steamid"];

				$qryStr = "SELECT * FROM tracks WHERE steamid='$sid';";

				if ($adminMode) {
					$qryStr = "SELECT * FROM tracks;";
				}

				$allMusQry = Query($qryStr);

				while ($row = mysqli_fetch_assoc($allMusQry)) {
					echo("<tr'>");
					echo("<td>" . urldecode($row["name"]) . "</td>");
					$fullURL = "https://the-sterling.co.uk/upload/" . $row["url"];
					if ($geo) { echo("<td><a href='" . $fullURL . "'>" . $fullURL . "</a></td>"); }
					echo("<td><a href='https://the-sterling.co.uk/delete.php?url=" . urlencode($row["url"]) . "'>Remove</a></td>");
					if ($adminMode) {
						echo("<td>" . $row["steamid"] . "</td>");
					}
					echo("</tr>");
				}
			?>
		</table>
		<p>Any questions? PM <a href="https://www.catalyst-gaming.net/index.php?action=profile;u=22593">Top Hatted Cat</a> on the Catalyst Gaming forums<!--sse--> or send an email to <a href="mailto:tophattedcat@tophattedcat.co.uk">tophattedcat@tophattedcat.co.uk</a><!--/sse-->.</p>
	</body>
</html>