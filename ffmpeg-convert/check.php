<?php
$logPath = __DIR__ . '/process.log';

// Read the last 10 lines of the log file
function tailLog($file, $lines = 10) {
    if (!file_exists($file)) {
        return "Log file not found.";
    }

    $output = [];
    exec("tail -n $lines " . escapeshellarg($file), $output);
    return implode("\n", $output);
}

// Check for success
$logContent = file_exists($logPath) ? file_get_contents($logPath) : '';
$conversionComplete = strpos($logContent, 'Conversion complete') !== false;
?>

<!DOCTYPE html>
<html>
<head>
    <title>FFmpeg Progress</title>
</head>
<body>
    <h1>FFmpeg Conversion Progress</h1>
    <p>Refresh the page to update.</p>

    <?php if ($conversionComplete): ?>
        <h2 style="color: green;">✅ Conversion complete!</h2>
    <?php endif; ?>

    <pre style="background:#f0f0f0; padding:1em; border:1px solid #ccc;">
<?php echo htmlspecialchars(tailLog($logPath)); ?>
    </pre>

    <a href="index.php">← Back to Upload</a>
</body>
</html>
