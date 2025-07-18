    <?php

    session_start();

    require_once 'db.php'; 

    $username = $password = "";
    $username_rr = $password_rr = $loginrr = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty(trim($_POST["username"]))){
            $username_rr = "Please enter username.";
        } else{
            $username = $_POST["username"];
        }

        if(empty(trim($_POST["password"]))){
            $password_rr = "Please enter your password.";
        } else{
            $password = $_POST["password"];
        }

        if(empty($username_rr) && empty($password_rr)){
            $query = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
            echo "<pre>$query</pre>"; 
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) >= 1) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                
                header("location: dashboard.php");
                exit();
            } else {
                $loginrr = "Login gagal, coba lagi bro.";
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
        <link rel="stylesheet" href="/public/style/style.css">
    </head>
    <body>
        <div class="login-container">
            <div class="login-box">
                <h2>Welcome, Hacker!</h2>
                <p>Login to start your challenge</p>
                
                <?php 
                if(!empty($loginrr)){
                    echo '<div style="color: red; margin-bottom: 10px;">' . $loginrr . '</div>';
                }        
                ?>
                
                <form action="login.php" method="POST">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username">
                        
                        <?php 
                        if(!empty($username_rr)){
                            echo '<div style="color: red; font-size: 0.8em;">' . $username_rr . '</div>';
                        }
                        ?>
                    </div>
                    
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password">

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

    <?php   
    mysqli_close($conn);
    ?>