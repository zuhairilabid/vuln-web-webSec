<?php
session_start();

require_once 'db.php'; 

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
    <link rel="stylesheet" href="../public/style/style.css">
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
            <a href="#" class="logo">CyberCourse</a>
        </div>
        <div class="header-right">
            <div class="profile">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
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
                        <p class="flag-content">WebSec{g00k1LLL_#r4j4_SQLi_t3l4h#_d4t4n99999!!!}</p>
                    </div>
                <?php endif; ?>
            
            <div class="course-grid">
                <?php
                $sql = "SELECT id, title, description, link FROM courses";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                ?>
                
                <div class="course-card">
                    <div class="card-header"><?= htmlspecialchars($row["title"]) ?></div>
                    <div class="card-body"><?= htmlspecialchars($row["description"]) ?></div>
                    <div class="card-footer">
                        <a href="<?= htmlspecialchars($row["link"]) ?>" class="btn">View Course</a>
                        <button class="btn btn-save" onclick="saveCourse(<?= $row['id'] ?>)">Simpan</button>
                    </div>
                </div>

                <?php 
                    endwhile;
                else:
                    echo "<p>Belum ada course yang tersedia saat ini.</p>";
                endif; 
                ?>
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

    function saveCourse(courseId) {
        fetch('save_course.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'course_id=' + courseId
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
    </script>

</body>
</html>
<?php
mysqli_close($conn);
?>