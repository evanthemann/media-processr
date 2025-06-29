<?php
$uploadDir = __DIR__ . '/uploads/';

// Make sure uploads folder exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video'])) {
    $uploadFile = $uploadDir . basename($_FILES['video']['name']);

    if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadFile)) {
        $message = "File uploaded successfully.";
    } else {
        $message = "Failed to upload file.";
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
    <input type="file" name="video" id="video" required><br><br>
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
