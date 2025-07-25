<?php
// --- Konfigurasi Database ---
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'vul_db');

// --- Koneksi awal ke server MySQL (tanpa menentukan database) ---
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Jika koneksi ke servernya aja gagal, stop semuanya
if($conn === false){
    die("ERROR: Gagal konek ke server MySQL. " . mysqli_connect_error());
}

// --- Cek apakah database sudah ada dengan cara yang lebih aman ---
// Kita query langsung untuk melihat apakah DB ada di daftar, ini menghindari exception
$db_check_query = mysqli_query($conn, "SHOW DATABASES LIKE '" . DB_NAME . "'");
$database_exists = mysqli_num_rows($db_check_query) > 0;

// Jika database TIDAK ADA, jalankan proses setup
if (!$database_exists) {
    
    // Karena database belum ada, kita jalankan proses setup sekali jalan
    echo "<div style='font-family: monospace; border: 1px solid #ccc; padding: 15px; margin: 20px; background-color: #f9f9f9;'>";
    echo "<h3>Setup Otomatis Dimulai... Database belum ada, sedang dibuat.</h3>";

    // 1. Buat Database
    $sql_create_db = "CREATE DATABASE " . DB_NAME;
    if (mysqli_query($conn, $sql_create_db)) {
        echo "✅ Database '" . DB_NAME . "' berhasil dibuat.<br>";
        mysqli_select_db($conn, DB_NAME); // Langsung pilih DB yang baru dibuat
    } else {
        die("❌ Gagal buat database: " . mysqli_error($conn));
    }

    // 2. Buat Tabel 'users'
    $sql_create_users = "CREATE TABLE users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        bio VARCHAR(255)
    )";
    if(mysqli_query($conn, $sql_create_users)){
        echo "✅ Tabel 'users' berhasil dibuat.<br>";
    } else { die("❌ Gagal buat tabel users: " . mysqli_error($conn)); }

    // 3. Buat Tabel 'courses'
    $sql_create_courses = "CREATE TABLE courses (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(100) NOT NULL,
        description TEXT,
        link VARCHAR(255)
    )";
    if(mysqli_query($conn, $sql_create_courses)){
        echo "✅ Tabel 'courses' berhasil dibuat.<br>";
    } else { die("❌ Gagal buat tabel courses: " . mysqli_error($conn)); }

    // 4. Isi data awal 'users'
    $insert_users_sql = "INSERT INTO users (username, password, bio) VALUES 
        ('admin', '1avc4ffj0eq4qzva', 'Aku adalah admin'), 
        ('diozahwan', 'nxhqu1bm4uj4a', 'Aku raja cybersec'), 
        ('ucup', '1av4xhahphcl4x', 'Aku orang paling ganteng'), 
        ('idol', '219jiamcxcdfads', 'FLAG:WebSec{ma@f_id0ruuu_k4l1an_b4ru_b4ngun_n1h}')";
    if(mysqli_query($conn, $insert_users_sql)) {
        echo "✅ Data awal untuk 'users' berhasil ditambahkan.<br>";
    } else {
        echo "❌ Gagal menambahkan data awal untuk 'users': " . mysqli_error($conn) . "<br>";
    }

    // 5. Isi data awal 'courses'
    $insert_courses_sql = "INSERT INTO courses (title, description, link) VALUES 
        ('SQL Injection Mastery', 'Learn to find and exploit SQLi vulnerabilities from scratch.', '#'),
        ('XSS for Pentesters', 'Master the art of Cross-Site Scripting in modern web apps.', '#')";
    if(mysqli_query($conn, $insert_courses_sql)) {
        echo "✅ Data awal untuk 'courses' berhasil ditambahkan.<br>";
    } else {
        echo "❌ Gagal menambahkan data awal untuk 'courses': " . mysqli_error($conn) . "<br>";
    }

    echo "<h3>🎉 Setup selesai! Halaman akan di-refresh dalam 3 detik...</h3>";
    echo "<script>setTimeout(() => { window.location.href = window.location.href; }, 3000);</script>";
    echo "</div>";
    
    // Hentikan eksekusi sisa halaman untuk kali ini, agar user melihat pesan setup
    die(); 
}

// Jika kode sampai sini, artinya database sudah pasti ada.
// Sekarang baru kita pilih database-nya untuk digunakan oleh sisa aplikasi.
mysqli_select_db($conn, DB_NAME);

// Variabel $conn sekarang siap digunakan.
?>
