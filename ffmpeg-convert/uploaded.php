<?php
$uploadDir = __DIR__ . '/uploads/';

/* 1️⃣ Expect ?file=FILENAME from the URL */
if (!isset($_GET['file']) || $_GET['file'] === '') {
    echo "No file specified.";
    exit;
}

$filename  = basename($_GET['file']);
$filepath  = $uploadDir . $filename;

/* 2️⃣ Confirm the file really exists in uploads/ */
if (!file_exists($filepath)) {
    echo "Uploaded file not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FFmpeg Convert - File Uploaded</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

<div class="w3-container w3-white w3-padding w3-margin w3-round-large">
    <a href="index.php">Home</a>

    <h2 class="w3-center">File Uploaded Successfully</h2>
    <p class="w3-center">File: <strong><?php echo htmlspecialchars($filename); ?></strong></p>

    <!-- Convert to 1080p (current) -->
    <form action="run.php" method="post" class="w3-center">
        <input type="hidden" name="filename" value="<?= htmlspecialchars($filename) ?>">
        <input type="hidden" name="preset"   value="1080p">
        <button class="w3-button w3-blue w3-margin-top" type="submit">
            Convert → 1080p MP4
        </button>
    </form>

    <!-- Extract audio (example) -->
    <form action="run.php" method="post" class="w3-center">
        <input type="hidden" name="filename" value="<?= htmlspecialchars($filename) ?>">
        <input type="hidden" name="preset"   value="mp3">
        <button class="w3-button w3-teal w3-margin-top" type="submit">
            Extract → MP3
        </button>
    </form>

    <!-- Make GIF (example) -->
    <form action="run.php" method="post" class="w3-center">
        <input type="hidden" name="filename" value="<?= htmlspecialchars($filename) ?>">
        <input type="hidden" name="preset"   value="gif">
        <button class="w3-button w3-orange w3-margin-top" type="submit">
            Make GIF
        </button>
    </form>

    <div class="w3-center w3-margin-top">
        <a href="index.php" class="w3-button w3-grey">Upload Another</a>
    </div>
</div>

</body>
</html>
