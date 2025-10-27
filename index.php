<?php
// Set security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Content-Security-Policy: default-src \'self\'; img-src \'self\'; style-src \'unsafe-inline\' \'self\'');

// Define debug variable
$debug = false; // Set to true only in development

if (!isset($_GET["code"])) {
  echo "no code specified<br>";
  if ($debug) {
    $dirs = array_filter(glob('codes/*'), 'is_dir');
    foreach ($dirs as $dir) {
      $dirparts = explode("/", $dir);
      $dirname = $dirparts[1];
      echo "<a href='" . htmlspecialchars($dir, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($dirname, ENT_QUOTES, 'UTF-8') . "</a><br>";
    }
  }
  die();
}

// Validate and sanitize the code parameter
$code = $_GET["code"] ?? '';
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $code)) {
    die("Invalid code format");
}

// Use the sanitized value
$dir = "codes/" . $code . "/";

// Additional check: ensure the resolved path is within codes directory
$realPath = realpath($dir);
$codesPath = realpath("codes/");
if (!$realPath || !str_starts_with($realPath, $codesPath)) {
    die("Access denied");
}

$codeFile = $dir . "code.json";
if (!file_exists($codeFile)) {
	die("Code not found");
}

$codeData = file_get_contents($codeFile);
$codeObj = json_decode($codeData);
if (!isset($codeObj) || !is_object($codeObj)) {
	die("Invalid code data format");
}

// Validate required fields
if (!isset($codeObj->CodeName) || !isset($codeObj->CodeImage) || !isset($codeObj->CodeCaption) || !isset($codeObj->CodeIcon)) {
	die("Missing required code data fields");
}
?>
<html>
<head>
<title><?php echo htmlspecialchars($codeObj->CodeName, ENT_QUOTES, 'UTF-8'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="apple-touch-icon" href="<?php echo htmlspecialchars($dir.$codeObj->CodeIcon, ENT_QUOTES, 'UTF-8'); ?>">
<link rel="apple-touch-startup-image" href="<?php echo htmlspecialchars($dir.$codeObj->CodeIcon, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="apple-mobile-web-app-title" content="<?php echo htmlspecialchars($codeObj->CodeName, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<style>
body {
  margin: 0px;
  padding: 0px;
  font-size: 1.4em;
  font-family: Arial, Helvetica, sans-serif;
  display: -webkit-flex;
  display: flex;
  -webkit-align-items: center;
  align-items: center;
  -webkit-justify-content: center;
  justify-content: center;
  display:block;
}
p, figcaption {
  text-align:center;
  margin: 0px;
  font-weight: bold;
}
.iconimg {
  border:3px solid white;
  border-radius: 20%;
}
.scannableimg {
  width:50%;
  display: block;
  margin-left: auto;
  margin-right: auto;
  padding: 18px;
  width: 35%;
}
@media only screen and (max-width: 800px) {
  .scannableimg {
    width:50%
  }
}
@media only screen and (max-width: 600px) {
  .scannableimg {
    width:95%;
    padding: 18px 54px 18px 10px;
  }
}

</style>
</head>
<body>
<p style="margin-top:20px;font-size:1.5em">
<img src="<?php echo htmlspecialchars($dir.$codeObj->CodeIcon, ENT_QUOTES, 'UTF-8'); ?>" width="100" style="width:100px" class="iconimg"><br>
<?php echo htmlspecialchars($codeObj->CodeName, ENT_QUOTES, 'UTF-8'); ?>
</p>
<img src="<?php echo htmlspecialchars($dir.$codeObj->CodeImage, ENT_QUOTES, 'UTF-8'); ?>" class="scannableimg" border=0>
<figcaption><?php echo htmlspecialchars($codeObj->CodeCaption, ENT_QUOTES, 'UTF-8'); ?></figcaption>
</body>
</html>