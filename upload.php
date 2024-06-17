<?php
$uploadDir = './uploads/'; // Directory where files will be stored
$allowedTypes = ['jpg', 'jpeg', 'png', 'pdf']; // Allowed file types

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo "Error: File upload failed with error code {$file['error']}";
        exit;
    }

    // Validate file type
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (!in_array(strtolower($fileExtension), $allowedTypes)) {
        http_response_code(400);
        echo "Error: Invalid file type. Allowed types: " . implode(', ', $allowedTypes);
        exit;
    }

    // Move uploaded file to destination directory
    $destination = $uploadDir . $file['name'];
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo "File uploaded successfully.";
    } else {
        http_response_code(500);
        echo "Error: Failed to move file to destination directory.";
    }
} else {
    http_response_code(400);
    echo "Error: POST request with 'file' parameter required.";
}
?>