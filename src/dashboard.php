<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Course Shop - Dashboard</title>
    <link rel="stylesheet" href="/public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="close-btn" id="close-btn">&times;</button>
        </div>
        <nav class="sidebar-nav">
            <a href="#">Dashboard</a>
            <a href="#">My Courses</a>
            <a href="#">My Profile</a>
            <a href="#">Settings</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <header class="header">
        <div class="header-left">
            <button class="hamburger-btn" id="hamburger-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a href="#" class="logo">CyberCourse</a>
        </div>
        <div class="header-right">
            <div class="profile">
                <span>Welcome, <?php echo $_SESSION['username']; ?>!</span>
                <div class="profile-icon">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1>Available Courses</h1>
            <p>Start your journey into cybersecurity with our expert-led courses.</p>
                <?php
                    if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'):
                    ?>
                        <div class="flag-box">
                            <p class="flag-title">-- ADMIN FLAG UNLOCKED --</p>
                            <p class="flag-content">FLAG{Adm1n_P4n3l_4cc3ss_G41n3d_V14_SQLi}</p>
                        </div>
                <?php endif; ?>
            <div class="course-grid">
                <div class="course-card">
                    <div class="card-header">SQL Injection Mastery</div>
                    <div class="card-body">Learn to find and exploit SQLi vulnerabilities from scratch.</div>
                    <div class="card-footer"><a href="#" class="btn">View Course</a></div>
                </div>
                <div class="course-card">
                    <div class="card-header">XSS for Pentesters</div>
                    <div class="card-body">Master the art of Cross-Site Scripting in modern web apps.</div>
                    <div class="card-footer"><a href="#" class="btn">View Course</a></div>
                </div>
                <div class="course-card">
                    <div class="card-header">Intro to Reverse Engineering</div>
                    <div class="card-body">Disassemble and understand malware and software.</div>
                    <div class="card-footer"><a href="#" class="btn">View Course</a></div>
                </div>
                <div class="course-card">
                    <div class="card-header">Binary Exploitation</div>
                    <div class="card-body">Dive deep into buffer overflows and memory corruption.</div>
                    <div class="card-footer"><a href="#" class="btn">View Course</a></div>
                </div>
                <div class="course-card">
                    <div class="card-header">Web Security Fundamentals</div>
                    <div class="card-body">A complete overview of common web vulnerabilities.</div>
                    <div class="card-footer"><a href="#" class="btn">View Course</a></div>
                </div>
                <div class="course-card">
                    <div class="card-header">Active Directory Hacking</div>
                    <div class="card-body">Learn techniques to compromise enterprise networks.</div>
                    <div class="card-footer"><a href="#" class="btn">View Course</a></div>
                </div>
            </div>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const closeBtn = document.getElementById('close-btn');
        const sidebar = document.getElementById('sidebar');

        if (hamburgerBtn && closeBtn && sidebar) {
            function toggleSidebar() {
                sidebar.classList.toggle('active');
            }
            hamburgerBtn.addEventListener('click', toggleSidebar);
            closeBtn.addEventListener('click', toggleSidebar);
        }
    });
    </script>

</body>
</html>