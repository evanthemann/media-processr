<?php
// index.php - Upload page with W3.CSS styling and file handling

$uploadDir = __DIR__ . '/uploads/';
$message = '';

// Ensure uploads directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Handle upload form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media'])) {
    // Delete all existing uploads first (single-file workflow)
    $existingFiles = glob($uploadDir . '*');
    foreach ($existingFiles as $file) {
        unlink($file);
    }

    $uploadedFile = $uploadDir . basename($_FILES['media']['name']);
    if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadedFile)) {
        // Redirect to uploaded confirmation page
        header("Location: uploaded.php?file=" . urlencode(basename($uploadedFile)));
        exit;
    } else {
        $message = 'Upload failed.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-padding">
    <a href="index.php">Home</a>
    <h2 class="w3-text-blue">Upload an Image</h2>

    <?php if ($message): ?>
        <div class="w3-panel w3-red w3-padding"> <?php echo htmlspecialchars($message); ?> </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="w3-container w3-card w3-padding">
        <label class="w3-text-grey">Select image file:</label>
        <input class="w3-input w3-border w3-margin-bottom" type="file" name="media" required>
        <button class="w3-button w3-green" type="submit">Upload</button>
    </form>
</body>
</html>
