<?php
// Basic validation
if (!isset($_POST['filename'], $_POST['preset'])) {
    die('Missing parameters.');
}

$filename = basename($_POST['filename']);
$preset   = $_POST['preset'];             // 1080p, mp3, gif, etc.

$uploadDir  = __DIR__ . '/uploads/';
$logFile    = __DIR__ . '/convert.log';   // reuse same log
$inputFile  = $uploadDir . $filename;

// Decide which shell script or FFmpeg command to run
switch ($preset) {
    case '1080p':
        $outputFile = $uploadDir . 'converted_' . $filename;
        $scriptPath = __DIR__ . '/scripts/convert_to_h264.sh';
        $cmd = "/bin/bash $scriptPath '$inputFile' '$outputFile' '$logFile'";
        break;

    case 'mp3':
        $outputFile = $uploadDir . pathinfo($filename, PATHINFO_FILENAME) . '.mp3';
        $scriptPath = __DIR__ . '/scripts/extract_mp3.sh';
        $cmd = "/bin/bash $scriptPath '$inputFile' '$outputFile' '$logFile'";
        break;

    case 'gif':
        $outputFile = $uploadDir . pathinfo($filename, PATHINFO_FILENAME) . '.gif';
        $scriptPath = __DIR__ . '/scripts/make_gif.sh';
        $cmd = "/bin/bash $scriptPath '$inputFile' '$outputFile' '$logFile'";
        break;

    default:
        die('Unknown preset.');
}

// Run in background and append FFmpeg output to log
shell_exec(escapeshellcmd($cmd) . " >> '$logFile' 2>&1 &");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Conversion Started</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-light-grey">
  <div class="w3-card w3-white w3-padding w3-margin-top">
      <h2 class="w3-text-green">Task Started (<?= htmlspecialchars($preset) ?>)</h2>
      <p>Processing <strong><?= htmlspecialchars($filename) ?></strong></p>
      <form action="check.php" method="get">
          <button class="w3-button w3-blue w3-margin-top">Check Progress</button>
      </form>
  </div>
</body>
</html>