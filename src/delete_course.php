<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login.']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $userId = $_SESSION['user_id'];
    $courseId = $_POST['course_id'];

    $deleteSql = "DELETE FROM user_courses WHERE user_id = ? AND course_id = ?";

    if ($stmt = mysqli_prepare($conn, $deleteSql)) {
        mysqli_stmt_bind_param($stmt, "ii", $userId, $courseId);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success', 'message' => 'Kursus berhasil dihapus.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus kursus: ' . mysqli_error($conn)]);
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