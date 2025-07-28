<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if (isset($_SESSION['can_see_flag']) && $_SESSION['can_see_flag'] === true) {
        unset($_SESSION['can_see_flag']);

    } else {
        header("location: dashboard.php");
        exit;
    }

} else {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flag Page - CyberCourse</title>
    <link rel="stylesheet" href="../public/style/style.css"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: #e0e0e0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #2c2c38;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1 {
            color: #6a0dad; 
            margin-bottom: 20px;
        }
        .flag-box {
            background-color: #1f1a30;
            border: 2px dashed #4CAF50;
            padding: 20px;
            margin-top: 30px;
            border-radius: 8px;
            font-size: 1.5em;
            font-weight: bold;
            color: #4CAF50; 
            word-break: break-all;
        }
        .back-link {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="container">
            <h1>Selamat! Anda Menemukan Flag Rahasia!</h1>
            <p>Ini adalah part 1 dari flag yang Anda cari:</p>
            <div class="flag-box">
                WebSec{G9_B4nG
            </div>
            <p style="margin-top: 20px;">Yeay berhasil, Tapi ini baru part1 flagnya. Coba gunakan Script lain.</p>
            <a href="support.php" class="back-link">Kembali ke Halaman Support</a>
        </div>
    </main>
</body>
</html>