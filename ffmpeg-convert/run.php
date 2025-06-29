<?php
// Make sure the filename is provided via URL
if (!isset($_GET['filename'])) {
    die("No filename provided.");
}

$filename = basename($_GET['filename']);
$inputPath = __DIR__ . '/uploads/' . $filename;
$outputPath = __DIR__ . '/uploads/converted_output.mp4';
$logPath = __DIR__ . '/process.log';

// If the form is submitted (button clicked), run ffmpeg
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Build the FFmpeg command
    $cmd = "/usr/local/bin/ffmpeg -i " . escapeshellarg($inputPath) .
           " -c:v libx264 -preset fast -crf 23 -vf scale=1920:1080 " .
           escapeshellarg($outputPath) . " > " . escapeshellarg($logPath) . " 2>&1 &";

    // Run the command in the background
    shell_exec($cmd);

    // Redirect to the progress page
    header("Location: check.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Run FFmpeg</title>
</head>
<body>
    <h1>Convert Uploaded Video</h1>
    <p>File to convert: <strong><?php echo htmlspecialchars($filename); ?></strong></p>

    <form method="POST">
        <input type="submit" value="Run FFmpeg Command">
    </form>
</body>
</html>
