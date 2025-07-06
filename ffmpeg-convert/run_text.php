<?php
/* Validate POST */
if (!isset($_POST['overlay'], $_POST['bg-color'])) {
    die('Missing params.');
}
$text     = $_POST['overlay'];            // keep raw; shell-escaped later
$bgcolor     = $_POST['bg-color'];            // keep raw; shell-escaped later

$dir        = __DIR__;

$scriptPath = "$dir/scripts/text_overlay.sh";

$logFile    = "$dir/convert.log";

/* Build and launch */
$cmd = "/bin/bash " . escapeshellarg($scriptPath) . ' '
     . escapeshellarg($text) . ' '
     . escapeshellarg($bgcolor) . ' '
     . escapeshellarg($logFile)
     . " >> " . escapeshellarg($logFile) . " 2>&1 &";

shell_exec($cmd);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Text Overlay Started</title>
  <link rel="stylesheet"
        href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-light-grey">
<div class="w3-card w3-white w3-padding w3-margin-top">
    <h3 class="w3-text-green">Overlay job started ✔︎</h3>
    <p>Processing </p>
    <?php echo $cmd ?>
    <form action="check.php" method="get">
        <button class="w3-button w3-blue">Check Progress</button>
    </form>
</div>
</body>
</html>
