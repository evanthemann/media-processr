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
    <title>Imagemagick Processr - File Uploaded</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

<div class="w3-container w3-white w3-padding w3-margin w3-round-large">
    <a href="index.php">Home</a>
    <h2 class="w3-center">File Uploaded Successfully</h2>
    <p class="w3-center">File: <strong><?php echo htmlspecialchars($filename); ?></strong></p>

    <!-- Resize -->
    <form action="run.php" method="post" class="w3-center">
        <input type="hidden" name="filename" value="<?= htmlspecialchars($filename) ?>">
        <input type="hidden" name="preset"   value="resize">
        <button class="w3-button w3-blue w3-margin-top" type="submit">
            Resize 800px jpg
        </button>
    </form>

    <!-- Black background 16x9 -->
    <form action="run.php" method="post" class="w3-center">
        <input type="hidden" name="filename" value="<?= htmlspecialchars($filename) ?>">
        <input type="hidden" name="preset"   value="blackbg">
        <button class="w3-button w3-teal w3-margin-top" type="submit">
            Black background 16x9 jpg
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


    <!-- pdf to jpg -->
    <form action="run.php" method="post" class="w3-center">
        <input type="hidden" name="filename" value="<?= htmlspecialchars($filename) ?>">
        <input type="hidden" name="preset"   value="pdftojpg">
        <button class="w3-button w3-green w3-margin-top" type="submit">
            Make GIF
        </button>
    </form>

    <!-- ── New button: send user to text-input page ── -->
    <form action="input.php" method="get" class="w3-center">
        <input type="hidden" name="filename" value="<?= htmlspecialchars($filename) ?>">
        <button class="w3-button w3-purple w3-margin-top">
            YouTube thumbnail
        </button>
    </form>


    <div class="w3-center w3-margin-top">
        <a href="index.php" class="w3-button w3-grey">Upload Another</a>
    </div>
</div>

</body>
</html>
