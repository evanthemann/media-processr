<!DOCTYPE html>
<html>
<head>
    <title>YouTube Thumbnail Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

<div class="w3-container w3-padding-16 w3-white w3-round w3-margin">
    <h1 class="w3-center">YouTube Thumbnail Generator</h1>
    <p class="w3-center">Upload an image and add text to generate a YouTube thumbnail.</p>
</div>

<div class="w3-container w3-padding-16 w3-white w3-round w3-margin">
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Image Upload -->
        <label for="image" class="w3-text-grey">Upload Image:</label>
        <input type="file" name="image" id="image" class="w3-input w3-border w3-margin-bottom" required>

        <!-- Text Input -->
        <label for="text" class="w3-text-grey">Add Text:</label>
        <input type="text" name="text" id="text" class="w3-input w3-border w3-margin-bottom" placeholder="Enter your text" required>

        <!-- Submit Button -->
        <button type="submit" class="w3-button w3-green w3-block">Generate Thumbnail</button>
    </form>
</div>

<div class="w3-container w3-padding-16 w3-white w3-round w3-margin">

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && isset($_POST['text'])) {
    $uploadDir = __DIR__ . "/uploads/";
    $relativeUploadDir = "uploads/";
    $scriptPath = __DIR__ . "/scripts/process_image.sh";

    // Sanitize and prepare filenames
    $originalFileName = $_FILES['image']['name'];
    $sanitizedFileName = preg_replace("/[^a-zA-Z0-9_-]/", "_", pathinfo($originalFileName, PATHINFO_FILENAME));
    $sanitizedFileName .= "." . pathinfo($originalFileName, PATHINFO_EXTENSION);

    $uploadFile = $uploadDir . $sanitizedFileName;
    $outputFile = $uploadDir . "output_" . $sanitizedFileName;
    $relativeOutputFile = $relativeUploadDir . "output_" . $sanitizedFileName;

    $text = escapeshellarg($_POST['text']); // Safe escaping

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        // Build and run the command
        $cmd = escapeshellcmd("bash $scriptPath " . escapeshellarg($uploadFile) . " " . escapeshellarg($outputFile) . " $text");
        $result = shell_exec($cmd);

        echo "<pre>$result</pre>";

        if (file_exists($outputFile)) {
            echo '<h3 class="w3-text-green">Thumbnail Preview:</h3>';
            echo '<div class="w3-center">';
            echo '<img src="' . $relativeOutputFile . '" alt="Generated Thumbnail" style="max-width:100%">';
            echo '</div>';
        } else {
            echo '<p class="w3-text-red">Error: Thumbnail generation failed.</p>';
        }
    } else {
        echo '<p class="w3-text-red">Error: File upload failed.</p>';
    }
}
?>

</div>

</body>
</html>
