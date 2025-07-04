<?php
$logFile = __DIR__ . '/convert.log';   //  <-- same path everywhere
?>
<!DOCTYPE html>
<html>
<head>
  <title>Progress</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-light-grey">
<div class="w3-card w3-white w3-padding w3-margin-top">
  <h2>FFmpeg Progress (last 10 lines)</h2>
  <pre class="w3-small w3-light-grey w3-padding">
<?php
if (file_exists($logFile)) {
    echo htmlspecialchars(shell_exec("tail -n 10 " . escapeshellarg($logFile)));
} else {
    echo "Log file not found.";
}
?>
  </pre>
  <form method="get"><button class="w3-button w3-blue">Refresh</button></form>
  <a href="index.php" class="w3-button w3-grey w3-margin-top">Back</a>
</div>
</body>
</html>
