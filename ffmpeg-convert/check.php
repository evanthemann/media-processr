<!DOCTYPE html>
<html>
<head>
    <title>FFmpeg Progress</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-light-grey">
<div class="w3-card w3-white w3-padding w3-margin-top">
    <a href="index.php">Home</a>

    <h2>FFmpeg Progress – last 10 lines</h2>

    <pre class="w3-small w3-light-grey w3-padding"><?php echo htmlspecialchars($tail); ?></pre>

    <form><button class="w3-button w3-blue">Refresh</button></form>
    <a href="index.php" class="w3-button w3-grey w3-margin-top">Back to Upload</a>
    <?php
    $logFile = __DIR__ . '/convert.log';           // <-- same file used in run.php & script
    $tail    = '';

    if (file_exists($logFile)) {
        $tail = shell_exec("tail -n 10 " . escapeshellarg($logFile));
        if ($tail === null || trim($tail) === '') {          // empty or unreadable
            $tail = "(log file exists but is empty)";
        }
    } else {
        $tail = "(log file not found)";
    }
    ?>
</div>
</body>
</html>
