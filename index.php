<?php
$path = ".";
$workingDir = dirname(__FILE__);

if (isset($_GET["p"])) {
	$path .= "/" . $_GET["p"];
}

$path = realpath($path);

if (strpos($path, $workingDir) != 0 || strpos($path, $workingDir) === FALSE)
	$path = ".";

$allFiles = scandir($path);

$directories = array();
$files = array();

foreach ($allFiles as $file) {
	if (realpath($path) == $workingDir && $file == basename(__FILE__))
		continue;

	if ($file == "." || $file == "..")
		continue;

	if (is_dir($path . "/" . $file)) {
		$contents = scandir($path . "/" . $file);
		$directories[$file] = count($contents) - 2;
	} else {
		$files[$file] = filesize($path . "/" . $file);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>swds</title>
</head>
<body>
<h1><?php
$part = str_replace($workingDir, "", $path);
if ($part == "") {
	echo("/");
	$shortpath = ".";
} else {
	echo($part);
	$shortpath = $part;
}
?></h1>

<ul id="files">
<?php
foreach ($directories as $directory => $items) {
	echo("
		<li>
			<a class=\"dir\" href=\"?p=$directory\">
				$directory <span>$items items</span>
			</a>
		</li>"
	);
}

foreach ($files as $file => $size) {
	echo("
		<li>
			<a class=\"dir\" href=\"$shortpath/$file\">
				$file <span>$size bytes</span>
			</a>
		</li>"
	);
}
?>
</ul>

</body>
</html>