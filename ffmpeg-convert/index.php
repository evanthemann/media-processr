<?php
$uploadDir = __DIR__ . '/uploads/';
$message = '';

// Ensure uploads directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// If a new file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media'])) {
    // Delete all existing uploads
    $existingFiles = glob($uploadDir . '*');
    foreach ($existingFiles as $file) {
        unlink($file);
    }

    $uploadedPath = $uploadDir . basename($_FILES['media']['name']);
    if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadedPath)) {
        // Redirect to run.php and pass the filename via POST
        header("Location: run.php?file=" . urlencode(basename($uploadedPath)));
        exit;
    } else {
        $message = '❌ Upload failed.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FFmpeg Convert - Upload Video</title>
</head>
<body>
    <h1>Upload a Video</h1>
    <?php if ($message): ?>
        <p style="color:red;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Select a video file:</label><br>
        <input type="file" name="media" required><br><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
