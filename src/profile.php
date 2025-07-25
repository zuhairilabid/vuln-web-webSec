<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$profile_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($profile_id === 0) {
    die("User ID not specified.");
}

$sql = "SELECT username, bio FROM users WHERE id = ?";
$user_data = [];

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $profile_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        die("User not found.");
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile - <?= htmlspecialchars($user_data['username']); ?></title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main-content">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-icon-large">
                        <?= strtoupper(substr(htmlspecialchars($user_data['username']), 0, 1)); ?>
                    </div>
                    <h2><?= htmlspecialchars($user_data['username']); ?></h2>
                </div>
                <div class="profile-body">
                    <h3>Bio:</h3>
                    <div class="bio-box">
                        <p>
                            <?php 
                                if (!empty($user_data['bio'])) {
                                    echo nl2br(htmlspecialchars($user_data['bio']));
                                } else {
                                    echo "<i>This user has not set a bio yet.</i>";
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="profile-footer">
                    <a href="dashboard.php" class="btn">&larr; Back to Dashboard</a>
                </div>
            </div>
            </div>
    </main>
</body>
</html>