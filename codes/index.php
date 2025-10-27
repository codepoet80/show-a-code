<?php
//Put a copy (or symlink) of this file in each code folder

// Sanitize and validate REQUEST_URI
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$requestUri = filter_var($requestUri, FILTER_SANITIZE_URL);

if (!$requestUri) {
    die('Invalid request');
}

$url = $requestUri;
$url = str_replace("code.php", "", $url);
$url = str_replace("index.php", "", $url);
$code = explode("/", $url);
$code = $code[count($code)-2];

// Validate code parameter
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $code)) {
    die('Invalid code format');
}

$depth = substr_count($url, "/");
$depth = $depth-2;
for ($i=0; $i<$depth; $i++) {
	$url = $url . "../";
}

if ($code != "codes") {
	$url = $url . "index.php?code=" . urlencode($code);
}

// Validate final URL before redirect
$parsedUrl = parse_url($url);
if ($parsedUrl === false || (isset($parsedUrl['host']) && $parsedUrl['host'] !== $_SERVER['HTTP_HOST'])) {
    die('Invalid redirect URL');
}

// Sanitize URL for header injection prevention
$url = preg_replace('/[\r\n]/', '', $url);

header('Location: ' . $url);
?>
