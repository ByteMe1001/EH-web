<?php
// Start session to check if the user is logged in
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    die("Unauthorized access.");
}

// Set upload directory path
$currentDirectory = getcwd();
$uploadDirectory = "/uploads/";

// Store errors
$errors = [];

// Allow multiple file types, including potential for malicious scripts
$fileExtensionsAllowed = ['jpeg', 'jpg', 'png', 'php']; // Include PHP for exploitation

$fileName = $_FILES['the_file']['name'];
$fileSize = $_FILES['the_file']['size'];
$fileTmpName  = $_FILES['the_file']['tmp_name'];
$fileType = $_FILES['the_file']['type'];

// Extract file extension
$fileExtension = strtolower(end(explode('.', $fileName)));

// Vulnerable upload path
$uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

if (isset($_POST['submit'])) {
    // No file extension check vulnerability (LFI exploitation possible)
    if (!in_array($fileExtension, $fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG, PNG, or PHP file.";
    }

    // Allow files larger than 4MB (intentional removal of size check)
    if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            echo "The file " . basename($fileName) . " has been uploaded.<br>";
            // Show the uploaded image if it's an image file
            if (in_array($fileExtension, ['jpeg', 'jpg', 'png'])) {
                echo "<img src='uploads/" . basename($fileName) . "' alt='Uploaded Image' style='max-width:500px;'><br>";
            }
        } else {
            echo "An error occurred. Please contact the administrator.";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";
        }
    }
}

// Vulnerable file inclusion point (LFI)
if (isset($_GET['file'])) {
    // Vulnerable to LFI as it includes any file from the 'uploads' folder without sanitization
    $file = $_GET['file'];
    include($currentDirectory . "/uploads/" . $file);  // Local File Inclusion (LFI) vulnerability
}
?>