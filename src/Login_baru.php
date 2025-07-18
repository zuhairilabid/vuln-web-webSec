<?php
require_once 'db.php'; 

$username = $password = "";
$username_rr = $password_rr = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $username_rr = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_rr = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty($username_rr) && empty($password_rr)){
        $inject = "SELECT id, username, password FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";

        $result = mysqli_query($conn, $inject);

        if($result){
            if(mysqli_num_rows($result) == 1){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: dashboard.php");
                exit();
            } else{
                $loginrr = "Tidak valod bro username dan pw nya";
            }
        } else{
            
            $loginrr = " Try again later";
        }
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cyber Course Shop</title>
    <link rel="stylesheet" href="/public/style/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Welcome, Hacker!</h2>
            <p>Login to start your challenge</p>
            <?php 
            if(!empty($login_err)){
                echo '<div style="color: red; margin-bottom: 10px;">' . $login_err . '</div>';
            }        
            ?>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                    <?php 
                    if(!empty($username_rr)){
                        echo '<div style="color: red; font-size: 0.8em;">' . $username_rr . '</div>';
                    }
                    ?>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <?php 
                    if(!empty($password_rr)){
                        echo '<div style="color: red; font-size: 0.8em;">' . $password_rr . '</div>';
                    }
                    ?>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>