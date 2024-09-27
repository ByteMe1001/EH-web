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

// Allowed MIME types for images only
$mimeTypesAllowed = ['image/jpeg', 'image/png'];

// Maximum file size (e.g., 4MB)
$maxFileSize = 4 * 1024 * 1024;

$fileName = $_FILES['the_file']['name'];
$fileSize = $_FILES['the_file']['size'];
$fileTmpName  = $_FILES['the_file']['tmp_name'];

// Use the file type from the $_FILES array
$detectedMimeType = $_FILES['the_file']['type'];

// Secure upload path
$uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

if (isset($_POST['submit'])) {
    // Check if the detected MIME type is allowed
    if (!in_array($detectedMimeType, $mimeTypesAllowed)) {
        $errors[] = "This file type is not allowed. Please upload a JPEG or PNG file.";
    }

    // Check if the file size exceeds the maximum limit
    if ($fileSize > $maxFileSize) {
        $errors[] = "The file is too large. Maximum allowed size is 4MB.";
    }

    // If no errors, proceed with the upload
    if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            echo "The file " . basename($fileName) . " has been uploaded.<br>";
            // Show the uploaded image if it's an image file
            if (in_array($detectedMimeType, ['image/jpeg', 'image/png'])) {
                echo "<img src='uploads/" . basename($fileName) . "' alt='Uploaded Image' style='max-width:500px;'><br>";
            }
        } else {
            echo "An error occurred during the file upload. Please contact the administrator.";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

// Vulnerable file inclusion point (LFI)
if (isset($_GET['file'])) {
    // Sanitize the file input to prevent directory traversal attacks
    $file = basename($_GET['file']);
    $filePath = $currentDirectory . "/uploads/" . $file;

    // Ensure the file exists and is within the allowed directory
    if (file_exists($filePath) && strpos(realpath($filePath), realpath($currentDirectory . "/uploads/")) === 0) {
        include($filePath);  // Be cautious: File inclusion should be used with care.
    } else {
        echo "File not found or invalid.";
    }
}
?>