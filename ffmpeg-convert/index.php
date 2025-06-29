<?php
$uploadDir = __DIR__ . '/uploads/';

// Make sure uploads folder exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media'])) {
    // Delete any existing files in the uploads folder
    $existingFiles = glob($uploadDir . '*');
    foreach ($existingFiles as $existing) {
        unlink($existing);
    }

    $uploadedPath = $uploadDir . basename($_FILES['media']['name']);
    if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadedPath)) {
        echo "<p><strong>File uploaded!</strong></p>";

        // Save filename in session or show run button immediately
        echo "<form action='process.php' method='POST'>";
        echo "<input type='hidden' name='filename' value='" . basename($uploadedPath) . "'>";
        echo "<button type='submit'>Run FFmpeg Command</button>";
        echo "</form>";
    } else {
        echo "<p><strong>Upload failed.</strong></p>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>FFmpeg Convert - Upload Video</title>
</head>
<body>
<a href="../index.php">Home</a>

<h1>Upload a Video to Convert</h1>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <label for="video">Select video file:</label><br>
    <input type="file" name="media" id="media" required><br><br>
    <input type="submit" value="Upload Video">
</form>

<h2>Uploaded Files:</h2>
<ul>
    <?php
    $files = scandir($uploadDir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo '<li>' . htmlspecialchars($file) . '</li>';
        }
    }
    ?>
</ul>

</body>
</html>
