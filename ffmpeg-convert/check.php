<?php
$logFile = __DIR__ . '/convert.log';
$convertedFile = __DIR__ . '/uploads/converted_output.mp4';
?>

<!DOCTYPE html>
<html>
<head>
    <title>FFmpeg Convert - Check Progress</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-light-grey">

<div class="w3-card w3-white w3-padding w3-margin-top">
    <h2>FFmpeg Conversion Progress</h2>

    <p>Last 10 lines of the log:</p>
    <pre class="w3-small w3-light-grey w3-padding">
<?php
if (file_exists($logFile)) {
    $lines = explode("\n", trim(shell_exec("tail -n 10 " . escapeshellarg($logFile))));
    foreach ($lines as $line) {
        echo htmlspecialchars($line) . "\n";
    }

    // Show message if conversion appears complete
    if (file_exists($convertedFile)) {
        echo "\n✅ Conversion appears to be complete.";
    }
} else {
    echo "Log file not found.";
}
?>
    </pre>

    <form method="get">
        <button class="w3-button w3-blue w3-margin-top">Refresh</button>
    </form>

    <a href="index.php" class="w3-button w3-grey w3-margin-top">Back to Upload Page</a>
</div>

</body>
</html>
