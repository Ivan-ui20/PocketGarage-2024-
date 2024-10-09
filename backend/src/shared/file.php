<?php

function handleFileUpload($file) {    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 2 * 1024 * 1024; 
    
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        
        if (!in_array($file['type'], $allowedTypes)) {
            error_log("File type not allowed: " . $file['type']);
            return false;
        }
        
        if ($file['size'] > $maxFileSize) {
            error_log("File size exceeds limit: " . $file['size']);
            return false;
        }
        
        $uploadDir = '../../upload/';
        
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                error_log("Failed to create directory: " . $uploadDir);
                return false;
            }
        }
        
        $fileName = uniqid() . '-' . basename($file['name']);
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $formatFilePath = "uploads/" . $fileName;
            return $formatFilePath; 
        } else {
            error_log("Failed to move uploaded file to: " . $filePath);
        }
    } else {
        error_log("File upload error: " . $file['error']);
    }
    
    return false; 
}


?>
