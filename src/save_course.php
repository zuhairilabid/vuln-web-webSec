<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login untuk menyimpan kursus.']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $userId = $_SESSION['user_id'];
    $courseId = $_POST['course_id'];

    $checkSql = "SELECT * FROM user_courses WHERE user_id = ? AND course_id = ?";
    if ($stmt = mysqli_prepare($conn, $checkSql)) {
        mysqli_stmt_bind_param($stmt, "ii", $userId, $courseId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo json_encode(['status' => 'info', 'message' => 'Kursus sudah ada di daftar Anda.']);
            mysqli_stmt_close($stmt);
            exit;
        }
        mysqli_stmt_close($stmt);
    }
    
    $insertSql = "INSERT INTO user_courses (user_id, course_id) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($conn, $insertSql)) {
        mysqli_stmt_bind_param($stmt, "ii", $userId, $courseId);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success', 'message' => 'Kursus berhasil disimpan!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan kursus: ' . mysqli_error($conn)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan query: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak valid.']);
}

mysqli_close($conn);
?>