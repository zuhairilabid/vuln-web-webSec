<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}

require_once 'db.php'; 

$username = $password = "";
$loginrr = ""; 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = mysqli_real_escape_string($conn, $_POST["username"]); // added an escape to make sure the input is read as plain text
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    if(empty($username) || empty($password)){
        $loginrr = "Invalid credentials.";
    } else {
        $sql_user_check = "SELECT * FROM users WHERE username = '$username'";
        $result_user_check = mysqli_query($conn, $sql_user_check);

        if ($result_user_check && mysqli_num_rows($result_user_check) == 1) {
            
            $user = mysqli_fetch_assoc($result_user_check);
            
            $sql_pass_check = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
            $result_pass_check = mysqli_query($conn, $sql_pass_check);
            
            if ($result_pass_check && mysqli_num_rows($result_pass_check) > 0) {
                
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user['username']; 
                $_SESSION['user_id'] = $user['id']; 
                
                header("location: dashboard.php");
                exit();

            } else {
                $loginrr = "Invalid credentials.";
            }

        } else {
            $loginrr = "Invalid credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cyber Course Shop</title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-page-container">
        <div class="login-box">
            <h2 class="login-title">CyberCourse</h2>
            <p class="login-subtitle">Welcome, Hacker! Authenticate to begin.</p>
            
            <?php if(!empty($loginrr)): ?>
                <div class="form-message-error"><?php echo $loginrr; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST" novalidate>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                    <?php if(!empty($username_rr)): ?>
                        <div class="form-message-error-small"><?php echo $username_rr; ?></div>
                    <?php endif; ?>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <?php if(!empty($password_rr)): ?>
                         <div class="form-message-error-small"><?php echo $password_rr; ?></div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-full">Login</button>
            </form>
        </div>
    </div>
</body>
</html>