<?php
// Location of uploaded files
$uploadDir = __DIR__ . '/uploads/';

// Check if filename is passed from index.php
if (!isset($_POST['filename'])) {
    echo "No file specified.";
    exit;
}

$filename = basename($_POST['filename']);
$filepath = $uploadDir . $filename;

// Double-check that the file actually exists
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
    <h2 class="w3-center">File Uploaded Successfully</h2>
    <p class="w3-center">File: <strong><?php echo htmlspecialchars($filename); ?></strong></p>

    <!-- Form to trigger FFmpeg conversion -->
    <form action="run.php" method="post" class="w3-center">
        <input type="hidden" name="filename" value="<?php echo htmlspecialchars($filename); ?>">
        <button class="w3-button w3-blue w3-margin-top" type="submit">Run FFmpeg Command</button>
    </form>

    <div class="w3-center w3-margin-top">
        <a href="index.php" class="w3-button w3-grey">Upload Another</a>
    </div>
</div>

</body>
</html>
