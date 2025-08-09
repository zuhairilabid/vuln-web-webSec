<?php
session_start();
require_once 'db.php'; 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$secret_flag = "WebSec{php_SST1_S3d3rh4n4_G1m4n4_Guy$?}";

$userId = $_SESSION['user_id'];
$search_query = "";
$search_output = "";
$sql_where_clause = "";

if (isset($_GET['search'])) {
    $search_query = $_GET['search'];

    $template = "Hasil pencarian untuk: " . $search_query;
    
    ob_start();
    eval("?><h1>" . htmlspecialchars($template) . "</h1><?php "); // menambahkan htmlspecialchars untuk mencegah injeksi html
    $search_output = ob_get_clean();
    
    $sql_where_clause = " AND c.title LIKE ?";
}

$sql = "SELECT c.id, c.title, c.description, c.link 
        FROM user_courses uc 
        JOIN courses c ON uc.course_id = c.id 
        WHERE uc.user_id = ?" . $sql_where_clause;
$stmt = mysqli_prepare($conn, $sql);

if ($sql_where_clause) {
    $search_param = '%' . $search_query . '%';
    mysqli_stmt_bind_param($stmt, "is", $userId, $search_param);
} else {
    mysqli_stmt_bind_param($stmt, "i", $userId);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Cyber Course Shop</title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .search-form-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .search-input {
            width: 300px;
            padding: 10px 15px;
            border: 1px solid #475569;
            background-color: #1e293b;
            color: #f1f5f9;
            border-radius: 8px;
            font-size: 1rem;
        }
        .search-button {
            padding: 10px 20px;
            background-color: #38f2af;
            color: #0f172a;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-button:hover {
            background-color: #2dd4aa;
        }
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
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <div class="profile-icon">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1>My Courses</h1>
            <p>Daftar kursus yang telah Anda simpan.</p>
            
            <form action="my_courses.php" method="GET" class="search-form-container">
                <input type="text" name="search" class="search-input" placeholder="Cari kursus berdasarkan nama..." value="<?= htmlspecialchars($search_query) ?>">
                <button type="submit" class="search-button">Cari</button>
            </form>
            
            <div class="search-output">
                <?= $search_output; ?>
            </div>
            
            <div class="course-grid">
                <?php
                if (mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                ?>
                
                <div class="course-card">
                    <div class="card-header"><?= htmlspecialchars($row["title"]) ?></div>
                    <div class="card-body"><?= htmlspecialchars($row["description"]) ?></div>
                    <div class="card-footer">
                        <a href="<?= htmlspecialchars($row["link"]) ?>" class="btn">View Course</a>
                        <button class="btn btn-delete" onclick="deleteCourse(<?= $row['id'] ?>)">Delete Course</button>
                    </div>
                </div>

                <?php 
                    endwhile;
                else:
                    echo "<p>Anda belum menyimpan kursus apa pun.</p>";
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

    function deleteCourse(courseId) {
        if (confirm("Apakah Anda yakin ingin menghapus kursus ini?")) {
            fetch('delete_course.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'course_id=' + courseId
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    window.location.reload(); 
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    }
    </script>

</body>
</html>
<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>