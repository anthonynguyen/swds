<?php
$path = ".";
$workingDir = dirname(__FILE__);
if (isset($_GET["p"]))
	$path .= "/" . $_GET["p"];

$tryPassword = "";
if (isset($_GET["password"]))
	$tryPassword = $_GET["password"];

$path = realpath($path);
if (strpos($path, $workingDir) != 0 || strpos($path, $workingDir) === FALSE)
	$path = realpath(".");

$allFiles = scandir($path);
$directories = array();
$files = array();

$lockedOut = False;
foreach ($allFiles as $file) {
	if (realpath($path) == $workingDir && $file == basename(__FILE__))
		continue;

	if ($file == "." || $file == "..")
		continue;

	if (is_dir($path . "/" . $file)) {
		$contents = scandir($path . "/" . $file);
		$directories[$file] = count($contents) - 2;
	} else {
		if (strpos($file, ".swds_password_") === 0) {
			$password = substr($file, 15);
			if ($tryPassword != $password) {
				$lockedOut = True;
				break;
			}

			continue;
		}
		
		$files[$file] = filesize($path . "/" . $file);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>swds</title>
	<link href="http://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" type="text/css">
	<style type="text/css">
	* {
		margin: 0;
		outline: 0;
		padding: 0;
	}

	html {
		background: #242833;
		color: #f0f0f0;
		font-family: "Lato", sans-serif;
		font-size: 12pt;
	}

	#all {
		margin: 0 auto;
		margin-top: 5%;
		width: 80%;
	}

	h1 {
		font-size: 3em;
		margin-bottom: 0.25em;
	}

	h1 a {
		color: #888;
		text-decoration: underline;
	}

	h1 a:hover {
		color: inherit;
	}

	ul {
		list-style-type: none;
	}

	li {
		display: inline-block;
		float: left;
	}

	li a {
		background: rgba(255, 255, 255, 0.05);
		border-radius: 0.15em;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		color: inherit;
		display: block;
		font-weight: 700;
		height: 7em;
		margin-bottom: 1em;
		margin-right: 1em;
		padding: 1em 1em 1em 7em;
		text-decoration: none;
		transition: 0.4s all;
		width: 18em;
		word-wrap: break-word;
	}

	li a:hover {
		background: rgba(255, 255, 255, 0.1);
	}

	li.file a {
		background-image: url(data:image/png;base64,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);
		background-repeat: no-repeat;
		background-position: 0.5em 0.5em;
		background-size: 6em 6em;
	}

	li.folder a {
		background-image: url(data:image/png;base64,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);
		background-repeat: no-repeat;
		background-position: 0.5em 0.5em;
		background-size: 6em 6em;
	}

	li a span {
		color: #ADB3CC;
		display: block;
		font-size: 0.8em;
		font-weight: 400;
		margin-top: 0.2em;
	}

	h2 {
		font-size: 2.4em;
		margin-top: 2em;
		text-align: center;
	}
	</style>
</head>
<body>
	<div id="all">
		<h1><?php
		$part = str_replace($workingDir, "", $path);
		if ($part == "") {
			echo("home");
			$shortpath = "";
		} else {
			$cpath = "";
			$link = "<a href=\"/\">home</a>";
			$parts = explode("/", $part);
			$last = array_pop($parts);

			foreach ($parts as $folder) {
				if (!strlen($folder))
					continue;

				$cpath .= "/" . $folder;
				$link .= " / <a href=\"?p=$cpath\">$folder</a>";
			}

			$link .= " / $last";
			
			echo($link);
			$shortpath = $part;
		}
		?></h1>

		
		<?php
		if ($lockedOut) {
			echo("<h2>You do not have access to view this folder.</h2>");
		} else {
			if (count($directories) + count($files) > 0) {
				echo("<ul>");
				foreach ($directories as $directory => $items) {
					echo("
						<li class=\"folder\">
							<a href=\"?p=$shortpath/$directory\">
								$directory <span>$items items</span>
							</a>
						</li>"
					);
				}

				foreach ($files as $file => $size) {
					echo("
						<li class=\"file\">
							<a href=\"$shortpath/$file\" download>
								$file <span>$size bytes</span>
							</a>
						</li>"
					);
				}
				echo("</ul>");
			} else {
				echo("<h2>Folder is empty! :(</h2>");
			}
		}
		?>
		</ul>
	</div>
</body>
</html>