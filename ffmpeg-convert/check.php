<?php
$logFile = __DIR__ . '/convert.log';      // same path used by your scripts
$tail    = '(log file not found)';
$url     = '';                            // will hold the final file URL

if (file_exists($logFile)) {
    // Grab last 10 lines
    $tailArr = explode("\n", trim(shell_exec("tail -n 10 " . escapeshellarg($logFile))));
    $tail    = implode("\n", $tailArr);

    // Scan for "➡️ View: <URL>"
    foreach ($tailArr as $line) {
        if (preg_match('/^➡️ View:\s+(.*)$/', $line, $m)) {
            $url = trim($m[1]);
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Conversion Progress</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-light-grey">
<div class="w3-card w3-white w3-padding w3-margin-top">

  <h2 class="w3-text-blue">Imagemagick Progress – last 10 lines</h2>
  <pre class="w3-small w3-light-grey w3-padding"><?= htmlspecialchars($tail) ?></pre>

  <?php if ($url): ?>
      <h3 class="w3-text-green">✅ Conversion complete</h3>
      <p><a class="w3-button w3-green" href="<?= htmlspecialchars($url) ?>" target="_blank">Download / View File</a></p>
      <!-- Inline preview for images (basic check) -->
      <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $url)): ?>
          <img src="<?= htmlspecialchars($url) ?>" style="max-width:100%;height:auto;border:1px solid #ccc;">
      <?php endif; ?>
  <?php else: ?>
      <p class="w3-text-orange">⏳ Still processing… refresh to check again.</p>
  <?php endif; ?>

  <form method="get">
      <button class="w3-button w3-blue w3-margin-top">Refresh</button>
  </form>
  <a href="index.php" class="w3-button w3-grey w3-margin-top">Back to Upload Page</a>
</div>
</body>
</html>
