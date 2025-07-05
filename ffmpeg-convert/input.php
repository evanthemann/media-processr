<?php
/* Expect ?file=FILENAME in URL */
if (!isset($_GET['filename']) || $_GET['filename'] === '') {
    die('No file specified.');
}
$filename = basename($_GET['filename']);      // sanitise
?>
<!DOCTYPE html>
<html>
<head>
  <title>Enter Text</title>
  <link rel="stylesheet"
        href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container w3-light-grey">

<div class="w3-card w3-white w3-padding w3-margin-top w3-round">
    <h2 class="w3-text-blue">Add Text Overlay</h2>
    <p>File: <strong><?= htmlspecialchars($filename) ?></strong></p>

    <form action="run_text.php" method="post" class="w3-container">
        <input type="hidden" name="filename"
               value="<?= htmlspecialchars($filename) ?>">

        <label class="w3-text-grey">Text to overlay:</label>
        <input class="w3-input w3-border w3-margin-bottom"
               type="text" name="overlay" required>

        <label class="w3-text-grey">background color:</label>
        <input class="w3-input w3-border w3-margin-bottom"
               type="text" name="bg-color" required>
        <p>yellow/gold #F7DC6F pale green (good) #C9E4CA pale blue #C5E3F4 pale red (good) #FFC6C9</p>

        <button class="w3-button w3-green">Start Processing</button>
    </form>
</div>

</body>
</html>
