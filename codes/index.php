<?php
//Put a copy (or symlink) of this file in each code folder
$url = $_SERVER['REQUEST_URI'];
$url = str_replace("code.php", "", $url);
$url = str_replace("index.php", "", $url);
$code = explode("/", $url);
$code = $code[count($code)-2];
$depth = substr_count($url, "/");
$depth = $depth-2;
for ($i=0; $i<$depth; $i++) {
	$url = $url . "../";
}
if ($code != "codes") {
	$url = $url . "index.php?code=" . $code;
}
header('Location: ' . $url);
?>
