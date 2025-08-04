<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$flag = "WebSec{gl000ry_gl000ry_k5m_cyb3333333r_uuuuPPnNnnVVVVVjj}";

$temp_dir = sys_get_temp_dir();
$flag_file = $temp_dir . DIRECTORY_SEPARATOR . 'LeFlag.txt';
$notes_file = $temp_dir . DIRECTORY_SEPARATOR . 'admin_notes.txt';

file_put_contents($flag_file, $flag);
file_put_contents($notes_file, "Hucucruh je sxusa jxu iushuj teskcudjqjyed yd BuVbqw.jnj");

file_put_contents('LeFlag.txt', $flag);
file_put_contents('admin_notes.txt', "Hucucruh je sxusa jxu iushuj teskcudjqjyed yd BuVbqw.jnj");

$lfi_content = "";
if (isset($_GET['lesson']) && !is_numeric($_GET['lesson'])) {
    $requested_file = $_GET['lesson'];
    
    $output = "";
    $is_command = false;
    
    function simulate_command($command, $args = '') {
        $current_dir = getcwd();
        $files = array(
            'LeFlag.txt' => 'WebSec{gl000ry_gl000ry_k5m_cyb3333333r_uuuuPPnNnnVVVVVjj}',
            'admin_notes.txt' => 'Hucucruh je sxusa jxu iushuj teskcudjqjyed yd BuVbqw.jnj',
        );
        
        switch ($command) {
            case 'cat':
                if (empty($args)) {
                    return "cat: missing file operand\nTry: cat filename.txt";
                }
                if (isset($files[$args])) {
                    return $files[$args];
                } elseif (file_exists($args)) {
                    return file_get_contents($args);
                } else {
                    return "cat: $args: No such file or directory";
                }
                
            case 'ls':
                return "Permission denied: Please try another method";
                
            case 'pwd':
                return 'Permission denied: Please try another method';
                
            case 'whoami':
                return 'Permission denied: Please try another method';
                
            case 'id':
                return 'Permission denied: Please try another method';
                
            case 'uname':
                return 'Permission denied: Please try another method';
                
            case 'ps':
                return 'Permission denied: Please try another method';
                
            case 'netstat':
                return 'Permission denied: Please try another method';
                
            default:
                return "Command '$command' not found";
        }
    }
    
    if (strpos($requested_file, '|') !== false) {
        $is_command = true;
        $parts = explode('|', $requested_file);
        $base_command_full = trim($parts[0]);
        
        if (preg_match('/^(cat|ls|pwd|whoami|id|uname|ps|netstat)\s*(.*)$/', $base_command_full, $matches)) {
            $base_command = $matches[1];
            $base_args = trim($matches[2]);
            $output = simulate_command($base_command, $base_args);
            
            for ($i = 1; $i < count($parts); $i++) {
                $pipe_cmd = trim($parts[$i]);
                if (strpos($pipe_cmd, 'grep') === 0) {
                    $grep_pattern = trim(str_replace('grep', '', $pipe_cmd));
                    $grep_pattern = trim($grep_pattern, '"\'');
                    
                    $lines = explode("\n", $output);
                    $filtered_lines = array();
                    foreach ($lines as $line) {
                        if (stripos($line, $grep_pattern) !== false) {
                            $filtered_lines[] = $line;
                        }
                    }
                    $output = implode("\n", $filtered_lines);
                }
            }
        } else {
            $output = "Command not recognized: " . $base_command_full;
        }
    } elseif (preg_match('/^(cat|ls|pwd|whoami|id|uname|ps|netstat)\s*(.*)$/', $requested_file, $matches)) {
        $is_command = true;
        $command = $matches[1];
        $args = trim($matches[2]);
        $output = simulate_command($command, $args);
    } else {
        if (file_exists($requested_file)) {
            $output = file_get_contents($requested_file);
        } else {
            $output = "File not found: " . $requested_file;
        }
    }
    
    if (!empty($output) || $is_command) {
        $lfi_content = "<div style='position: fixed; top: 10px; right: 10px; background: rgba(0,0,0,0.95); color: #00ff00; padding: 15px; border-radius: 8px; z-index: 9999; max-width: 500px; font-family: monospace; font-size: 12px; max-height: 80vh; overflow-y: auto;'>";
        
        if ($is_command) {
            $lfi_content .= "<div style='color: #ff6b6b; margin-bottom: 10px;'>⚠️ CRITICAL: Command injection detected!</div>";
            $lfi_content .= "<div style='color: #ffc107; margin-bottom: 5px;'>Command: " . htmlspecialchars($requested_file) . "</div>";
        } else {
            $lfi_content .= "<div style='color: #ff6b6b; margin-bottom: 10px;'>⚠️ DEBUG: Unauthorized file access detected!</div>";
            $lfi_content .= "<div style='color: #ffc107; margin-bottom: 5px;'>File: " . htmlspecialchars($requested_file) . "</div>";
        }
        
        $lfi_content .= "<div style='background: rgba(0,0,0,0.8); padding: 10px; border-radius: 4px; margin: 10px 0;'>";
        $lfi_content .= "<pre style='color: #00ff00; margin: 0; white-space: pre-wrap; font-size: 11px;'>" . htmlspecialchars($output) . "</pre>";
        $lfi_content .= "</div>";
        
        $lfi_content .= "<div style='margin-top: 10px; font-size: 10px; color: #94a3b8;'>CTF Challenge: LFI + Command Injection</div>";
        $lfi_content .= "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Mastery - CyberCourse</title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .lesson-container {
            margin-bottom: 15px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #334155;
            transition: all 0.3s ease;
        }
        
        .lesson-box {
            background-color: #1e293b;
            color: #f8fafc;
            padding: 20px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .lesson-box:hover {
            background-color: #334155;
        }
        
        .lesson-container.active .lesson-box {
            background-color: #334155;
        }
        
        .lesson-title {
            font-size: 1.1rem;
        }
        
        .lesson-arrow {
            font-size: 1.2rem;
            color: #38f2af;
            transition: transform 0.3s ease;
        }
        
        .lesson-container.active .lesson-arrow {
            transform: rotate(180deg);
        }
        
        .lesson-content {
            background-color: #0f172a;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            border-top: 1px solid #334155;
        }
        
        .lesson-container.active .lesson-content {
            max-height: 300px;
            padding: 25px;
        }
        
        .lesson-description {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        
        .learn-button {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 12px 24px;
            background: #64FFDA;
            color: #000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .learn-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(100, 255, 218, 0.4);
            background: #4FDFBA;
        }
        
        .course-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .course-title {
            font-size: 2rem;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .course-desc {
            font-size: 1.1rem;
            color: #cbd5e1;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .course-selection {
            display: grid;
            gap: 15px;
        }

        /* Help button styles */
        .help-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            color: #38f2af;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 12px 20px;
            z-index: 1000;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: #1e293b;
            margin: 15% auto;
            padding: 30px;
            border: 1px solid #334155;
            border-radius: 12px;
            width: 80%;
            max-width: 500px;
            color: #f8fafc;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #38f2af;
        }

        .modal-message {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 25px;
            color: #cbd5e1;
        }

        .close {
            color: #94a3b8;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 15px;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #f8fafc;
        }

        .modal-button {
            background: #38f2af;
            color: #000;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .modal-button:hover {
            background: #2dd4aa;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(56, 242, 175, 0.4);
        }

</style>
</head>
<body>
    <?php echo $lfi_content; ?>
    
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
            <a href="#" class="logo">CyberCourse</a>
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
                <a href="dashboard.php" style="color: #38f2af; text-decoration: none; font-size: 0.9rem;">
                    ← Back to Dashboard
                </a>
            </div>
            
            <!-- Help Button -->
            <a href="#" class="help-button" id="helpButton">
                Need Help ?
            </a>
            
            <!-- Modal -->
            <div id="helpModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeModal">&times;</span>
                    <div class="modal-header">System Help</div>
                    <div class="modal-message">
                        If the lessons didn't show up, Try debug the web
                    </div>
                    <button class="modal-button" id="modalOkButton">OK</button>
                </div>
            </div>
            <div class="course-title">SQL Injection Mastery: Course Overview</div>
            <div class="course-desc">
                This course offers a practical guide to SQL Injection vulnerabilities, covering how they function, identification methods, and crucially, prevention. 
                Geared towards developers and security professionals, it emphasizes defensive programming and secure coding to protect web applications from this common threat.
                
                <?php if (isset($_GET['debug']) && $_GET['debug'] == 'true'): ?>
                <div style="margin-top: 15px; padding: 10px; background: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107; border-radius: 4px;">
                    <div style="color: #ffc107; font-weight: bold; margin-bottom: 5px;">🔍 Debug Mode Enabled</div>
                    <div style="color: #94a3b8; font-size: 0.9rem;">
                        <strong>Hint 2:</strong> check the code structure<br>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="course-selection">
                <div class="lesson-container" data-lesson="1">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 1: SQL Injection Fundamentals</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Learn the basics of SQL Injection attacks, including how they work, common attack vectors, and why they remain one of the most dangerous web vulnerabilities. This lesson covers the fundamental concepts, types of SQL injection, and real-world examples to help you understand the threat landscape.
                        </div>
                        <a href="?lesson=1" class="learn-button">Learn This Topic</a>
                    </div>
                </div>

                <div class="lesson-container" data-lesson="2">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 2: Detecting SQL Injection Vulnerabilities</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Master the techniques for identifying SQL injection vulnerabilities in web applications. This lesson covers manual testing methods, automated scanning tools, code review practices, and how to recognize vulnerable code patterns in different programming languages and frameworks.
                        </div>
                        <a href="?lesson=2" class="learn-button">Learn This Topic</a>
                    </div>
                </div>

                <div class="lesson-container" data-lesson="3">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 3: Defensive Strategies for SQLi</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Explore comprehensive defense mechanisms against SQL injection attacks. This lesson covers parameterized queries, stored procedures, input validation, output encoding, and the principle of least privilege. Learn how to implement multiple layers of security to protect your applications.
                        </div>
                        <a href="?lesson=3" class="learn-button">Learn This Topic</a>
                    </div>
                </div>

                <div class="lesson-container" data-lesson="4">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 4: Practical Prevention and Advanced Mitigation Techniques</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Apply advanced prevention techniques and implement enterprise-level security measures. This lesson covers Web Application Firewalls (WAF), database security hardening, monitoring and logging strategies, and how to create a comprehensive security framework for production environments.
                        </div>
                        <a href="?lesson=4" class="learn-button">Learn This Topic</a>
                    </div>
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

        const lessonContainers = document.querySelectorAll('.lesson-container');
        
        lessonContainers.forEach(container => {
            const lessonBox = container.querySelector('.lesson-box');
            
            lessonBox.addEventListener('click', function() {
                lessonContainers.forEach(otherContainer => {
                    if (otherContainer !== container) {
                        otherContainer.classList.remove('active');
                    }
                });
                container.classList.toggle('active');
            });
        });

        // Additional informations
        console.log('%c See the admin notes for more information');
        console.log('%c Admin Notes can be found in admin_notes.txt');
   

        // Help modal functionality
        const helpButton = document.getElementById('helpButton');
        const helpModal = document.getElementById('helpModal');
        const closeModal = document.getElementById('closeModal');
        const modalOkButton = document.getElementById('modalOkButton');

        if (helpButton && helpModal) {
            helpButton.addEventListener('click', function(e) {
                e.preventDefault();
                helpModal.style.display = 'block';
            });

            function closeModalFunction() {
                helpModal.style.display = 'none';
            }

            if (closeModal) {
                closeModal.addEventListener('click', closeModalFunction);
            }

            if (modalOkButton) {
                modalOkButton.addEventListener('click', closeModalFunction);
            }

            // Close modal when clicking outside of it
            window.addEventListener('click', function(event) {
                if (event.target === helpModal) {
                    closeModalFunction();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && helpModal.style.display === 'block') {
                    closeModalFunction();
                }
            });
        }
    });
    </script>
</body>
</html>
