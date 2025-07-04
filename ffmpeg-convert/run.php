<?php
// Validate POST
if (!isset($_POST['filename'])) {
    echo "No filename received.";  exit;
}

$filename   = basename($_POST['filename']);
$uploadDir  = __DIR__ . '/uploads/';
$scriptPath = __DIR__ . '/scripts/convert_to_h264.sh';
$logPath    = __DIR__ . '/convert.log';          //  <-- unified log file !

$inputFile  = $uploadDir . $filename;
$outputFile = $uploadDir . 'converted_' . $filename;

/* Run the shell script in the background
   Pass the log‑file path as the 3rd arg
   Also redirect ffmpeg’s own stdout/stderr to the same log */
$cmd = escapeshellcmd(
        "/bin/bash $scriptPath "
        . escapeshellarg($inputFile) . ' '
        . escapeshellarg($outputFile) . ' '
        . escapeshellarg($logPath)
      ) . " >> " . escapeshellarg($logPath) . " 2>&1 &";

shell_exec($cmd);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Conversion Started</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-light-grey">
  <div class="w3-card w3-white w3-padding w3-margin-top">
      <h2 class="w3-text-green">Conversion Started</h2>
      <p>The file <strong><?php echo htmlspecialchars($filename); ?></strong> is being processed.</p>
      <form action="check.php" method="get">
          <button class="w3-button w3-blue w3-margin-top" type="submit">Check Progress</button>
      </form>
  </div>
</body>
</html>
