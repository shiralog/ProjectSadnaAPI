<?php
// upload.php

// Allow from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && isset($_POST['group_id'])) {
        $file = $_FILES['file'];
        $group_id = $_POST['group_id'];
        
        // Create the directory if it doesn't exist
        $upload_dir = 'uploads/' . $group_id;
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Move the uploaded file to the group folder
        $file_path = $upload_dir . '/' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>