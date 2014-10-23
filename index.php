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

Directories:
<ul id="directories">
<?php
foreach ($directories as $directory => $items) {
	echo("<li>$directory ($items items)</li>");
}
?>
</ul>

Files:
<ul id="files">
<?php
foreach ($files as $file => $size) {
	echo("<li>$file ($size bytes)</li>");
}
?>
</ul>

</body>
</html>