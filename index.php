<?php
if (!isset($_GET["code"])) {
  echo "no code specified<br>";
  if ($debug) {
    $dirs = array_filter(glob('codes/*'), 'is_dir');
    foreach ($dirs as $dir) {
      $dirparts = explode("/", $dir);
      $dirname = $dirparts[1];
      echo "<a href='" . $dir . "'>" . $dirname . "</a><br>";
    }
  }
  die();
}

$dirname = $_GET["code"];
$file_name = preg_replace( '/[^a-zA-Z0-9]+/', '-', $dirname );
$dir = "codes/" . $_GET["code"] . "/";

$codeFile = $dir . "code.json";
if (!file_exists($codeFile)) {
	die("no code data at: " .$codeFile);
}

$codeData = file_get_contents($codeFile);
$codeObj = json_decode($codeData);
if (!isset($codeObj)) {
	die("bad code data: ". $codeData);
}
?>
<html>
<head>
<title><?php echo $codeObj->CodeName; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="apple-touch-icon" href="<?php echo $dir.$codeObj->CodeIcon; ?>">
<link rel="apple-touch-startup-image" href="<?php echo $dir.$codeObj->CodeIcon; ?>">
<meta name="apple-mobile-web-app-title" content="<?php echo $codeObj->CodeName; ?>">
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
<img src="<?php echo $dir.$codeObj->CodeIcon; ?>" width="100" style="width:100px" class="iconimg"><br>
<?php echo $codeObj->CodeName; ?>
</p>
<img src="<?php echo $dir.$codeObj->CodeImage; ?>" class="scannableimg" border=0></a>
<figcaption><?php echo $codeObj->CodeCaption; ?></figcaption>
</body>
</html>