<?php
require "header.php";

$error = "";
$success = "";

function uploadPortfolioFile($file) {

    if (!isset($file) || $file['error'] !== 0) {
        throw new Exception("No file selected or upload error.");
    }

    $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024;

    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmp  = $file['tmp_name'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedTypes)) {
        throw new Exception("Invalid file type.");
    }

    if ($fileSize > $maxSize) {
        throw new Exception("File must be less than 2MB.");
    }

    if (!file_exists("uploads")) {
        mkdir("uploads");
    }

    $newName = "portfolio_" . time() . "." . $ext;
    $destination = "uploads/" . $newName;

    if (!move_uploaded_file($fileTmp, $destination)) {
        throw new Exception("File upload failed.");
    }

    return $newName;
}

if (isset($_POST['upload'])) {
    try {
        $success = "File uploaded: " . uploadPortfolioFile($_FILES['portfolio']);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<h3>Upload Portfolio File</h3>

<?php
if ($error) echo "<p style='color:red;'>$error</p>";
if ($success) echo "<p style='color:green;'>$success</p>";
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="portfolio"><br><br>
    <input type="submit" name="upload" value="Upload File">
</form>

<?php
require "footer.php";
?>