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
    <title>Client-Side Security - CyberCourse</title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .lesson-container { margin-bottom: 15px; border-radius: 12px; overflow: hidden; border: 1px solid #334155; transition: all 0.3s ease; }
        .lesson-box { background-color: #1e293b; color: #f8fafc; padding: 20px 25px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: bold; transition: all 0.3s ease; }
        .lesson-box:hover, .lesson-container.active .lesson-box { background-color: #334155; }
        .lesson-title { font-size: 1.1rem; }
        .lesson-arrow { font-size: 1.2rem; color: #38f2af; transition: transform 0.3s ease; }
        .lesson-container.active .lesson-arrow { transform: rotate(180deg); }
        .lesson-content { background-color: #0f172a; padding: 0; max-height: 0; overflow: hidden; transition: all 0.3s ease; border-top: 1px solid #334155; }
        .lesson-container.active .lesson-content { max-height: 500px; /* Disesuaikan */ padding: 25px; }
        .lesson-description { color: #94a3b8; line-height: 1.6; margin-bottom: 20px; font-size: 0.95rem; }
        .course-container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .course-title { font-size: 2rem; margin-bottom: 15px; font-weight: bold; color: var(--white); }
        .course-desc { font-size: 1.1rem; color: #cbd5e1; margin-bottom: 30px; line-height: 1.6; }
        .course-selection { display: grid; gap: 15px; }
        .lock-icon { margin-right: 10px; color: #f87171; }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="close-btn" id="close-btn">&times;</button>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="my_courses.php">My Courses</a>
            <a href="profile.php?user_id=<?php echo htmlspecialchars($_SESSION['user_id']); ?>">My Profile</a>
            <a href="settings.php">Settings</a>
            <a href="support.php">Support</a>
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
            <a href="dashboard.php" class="logo">CyberCourse</a>
        </div>
        <div class="header-right">
            <div class="profile">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <div class="profile-icon">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
            </div>
        </div>
    </header>
    <main class="main-content">
        <div class="course-container">
            <div style="margin-bottom: 20px;">
                <a href="dashboard.php" style="color: #38f2af; text-decoration: none; font-size: 0.9rem;">← Back to Dashboard</a>
            </div>
            <div class="course-title">Client-Side Security: Bypassing Controls</div>
            <div class="course-desc">
                This premium course explores the critical vulnerabilities that arise when security decisions are improperly trusted to the client-side. Learn to identify and exploit these flaws through practical, hands-on examples.
            </div>

            <div class="course-selection">
                <div class="lesson-container" data-lesson="1">
                    <div class="lesson-box"><span class="lesson-title">Lesson 1: The Illusion of Client-Side Security</span><span class="lesson-arrow">▼</span></div>
                    <div class="lesson-content">
                        <div class="lesson-description">Understand why client-side validation is a convenience, not a security measure. This lesson covers the fundamental principles of the client-server model and why the server should always be the single source of truth for security enforcement.</div>
                    </div>
                </div>

                <div class="lesson-container" data-lesson="2">
                    <div class="lesson-box">
                        <span class="lesson-title"><span class="lock-icon">🔒</span>Lesson 2: Practical Bypass Techniques</span>
                        <span class="lesson-arrow">▼</span>
                    </div>
                    <div class="lesson-content">
                        <div class="input-group" style="margin-bottom: 15px;">
                            <label for="access_code" style="color: var(--light-slate); display:block; margin-bottom: 8px;">Access Code:</label>
                            <input type="text" id="access_code" placeholder="Enter the code to unlock..." style="width: 100%; padding: 12px; background-color: var(--dark-navy); border: 1px solid var(--lightest-navy); border-radius: 4px; color: var(--white); font-family: var(--font-mono);">
                        </div>
                        <button class="btn" onclick="unlockContent()" style="font-weight:700;">Validate Code</button>
                        
                        <div id="challenge-result" style="margin-top: 20px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../public/js/course_validator.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const lessonContainers = document.querySelectorAll('.lesson-container');
        lessonContainers.forEach(container => {
            const lessonBox = container.querySelector('.lesson-box');
            lessonBox.addEventListener('click', function() {
                container.classList.toggle('active');
            });
        });
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
        const openModalBtn = document.getElementById('openGiveFeedbackModal');
        const closeModalBtn = document.getElementById('closeGiveFeedbackModal');
        const feedbackModal = document.getElementById('giveFeedbackModal');
        if (openModalBtn && closeModalBtn && feedbackModal) {
            openModalBtn.onclick = function() {
                feedbackModal.style.display = "flex";
            }
            closeModalBtn.onclick = function() {
                feedbackModal.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == feedbackModal) {
                    feedbackModal.style.display = "none";
                }
            }
        }
    }); 
    </script>
</body>
</html>
