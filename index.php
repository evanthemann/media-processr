<?php
$uploadDir = '/usr/local/var/www/uploads/';
$processedFile = '/usr/local/var/www/resized_output.png';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media'])) {
    $uploadedPath = $uploadDir . basename($_FILES['media']['name']);
    if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadedPath)) {
        $cmd = "/usr/local/bin/convert " . escapeshellarg($uploadedPath) . " -resize 800x800 " . escapeshellarg($processedFile) . " 2>&1";
        echo "<pre>Command: $cmd</pre>";
        $output = shell_exec($cmd);
        echo "<p><strong>File uploaded and processed!</strong></p>";
        echo "<h3>Processed Image Preview:</h3>";
        echo "<img src='resized_output.png' style='max-width:100%; height:auto; border:1px solid #ccc; margin-top:1em;'>";
        echo "<pre>$output</pre>";
    } else {
        echo "<p><strong>Upload failed.</strong></p>";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <label>Select a video or image:</label><br>
    <input type="file" name="media" required><br><br>
    <input type="submit" value="Upload & Process">
</form>

