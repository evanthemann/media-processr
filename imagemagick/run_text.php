<?php
/* Validate POST */
if (!isset($_POST['filename'], $_POST['overlay'])) {
    die('Missing params.');
}
$filename = basename($_POST['filename']);
$text     = $_POST['overlay'];            // keep raw; shell-escaped later

$dir        = __DIR__;
$uploadDir  = "$dir/uploads/";
$scriptPath = "$dir/scripts/text_overlay.sh";
$logFile    = "$dir/convert.log";

$inputFile  = $uploadDir . $filename;
$outputFile = $uploadDir . 'overlay_' . pathinfo($filename, PATHINFO_FILENAME) . '.jpg';

/* Build and launch */
$cmd = "/bin/bash " . escapeshellarg($scriptPath) . ' '
     . escapeshellarg($inputFile) . ' '
     . escapeshellarg($outputFile) . ' '
     . escapeshellarg($text) . ' '
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
    <p>Processing <strong><?= htmlspecialchars($filename) ?></strong></p>
    <form action="check.php" method="get">
        <button class="w3-button w3-blue">Check Progress</button>
    </form>
</div>
</body>
</html>
