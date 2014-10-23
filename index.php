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

	if (is_dir($path . "/" . $file))
		$directories[] = $file;
	else
		$files[] = $file;
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
foreach ($directories as $directory) {
	echo("<li>$directory</li>");
}
?>
</ul>

Files:
<ul id="files">
<?php
foreach ($files as $file) {
	echo("<li>$file</li>");
}
?>
</ul>

</body>
</html>