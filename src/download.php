<?php
session_start();
if (!isset($_GET['file'])) {
    http_response_code(400);
    die('Error: No file specified.');
}

$file_name = basename($_GET['file']);
$base_dir = __DIR__;
$full_path = $base_dir . '/download/' . $file_name;
$full_path = realpath($full_path);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (strpos($full_path, $base_dir) !== 0) {
    http_response_code(403);
    die('Error: Invalid file path.');
}

if (isset($_GET['file'])) {

    if (strtolower(substr($file_name, -4)) === '.php') {
        http_response_code(403); 
        die('Error: Access to this file type is denied.'); // Flag: WebSec{f1l3_typ3_r3str1ct10n}
    }

    if (is_readable($full_path)) {
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . basename($full_path) . '"');
        header('Content-Length: ' . filesize($full_path));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        ob_clean();
        flush();
        readfile($full_path);
        exit;
    } else {
        http_response_code(404);
        die('Error: File not found or is not readable.');
    }
} else {
    http_response_code(400);
    die('Error: No file specified.');
}
/*
$allowed_files = [
    'legacy_notes.txt' => 'legacy_notes.txt'
];

$file_key = isset($_GET['file']) ? $_GET['file'] : '';

if (array_key_exists($file_key, $allowed_files)) {
    $file_path = $allowed_files[$file_key];

    if (file_exists($file_path) && is_readable($file_path)) {
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Content-Length: ' . filesize($file_path));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        ob_clean();
        flush();
        readfile($file_path);
        exit;
    } else {
        http_response_code(404);
        die('Error: File not found.');
    }
} else {
    http_response_code(403);
    die('Error: Access denied.');
}*/
?>