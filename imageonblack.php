<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>media processr</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
</head>
<body>

<div class="w3-container">

<?php
$uploadDir = '/usr/local/var/www/media-processr/uploads/';
$processedFile = '/usr/local/var/www/media-processr/uploads/resized_output.png';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media'])) {
    $uploadedPath = $uploadDir . basename($_FILES['media']['name']);
    if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadedPath)) {
        $cmd = "/usr/local/bin/convert " . escapeshellarg($uploadedPath) . " -auto-orient -resize 1920x1080 -size 1920x1080 xc:black +swap -gravity center -composite " . escapeshellarg($processedFile) . " 2>&1";
        echo "<pre>Command: $cmd</pre>";
        $output = shell_exec($cmd);
        echo "<p><strong>File uploaded and processed!</strong></p>";
        echo "<h3>Processed Image Preview:</h3>";
        echo "<img src=$processedFile style='max-width:100%; height:auto; border:1px solid #ccc; margin-top:1em;'>";
        echo "<pre>$output</pre>";
    } else {
        echo "<p><strong>Upload failed.</strong></p>";
    }
}
?>

<h2>Place on 16x9</h2>

<form method="post" enctype="multipart/form-data">
    <label>Select an image:</label><br>
    <input type="file" name="media" required><br><br>
    <input type="submit" value="Upload & Place on 16x9">
</form>

</div>
    
</body>
</html>
