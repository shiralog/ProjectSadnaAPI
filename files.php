<?php
// files.php

// Allow from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['group_id'])) {
        $group_id = $_GET['group_id'];
        $upload_dir = 'uploads/' . $group_id;
        
        if (file_exists($upload_dir)) {
            $files = array_diff(scandir($upload_dir), ['.', '..']);
            echo json_encode(['status' => 'success', 'files' => $files]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Group not found.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>