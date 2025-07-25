<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'vul_db');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (mysqli_query($conn, $sql_create_db)) {
    echo "Database '" . DB_NAME . "' berhasil dibuat atau sudah ada.<br>";
} else {
    die("Gagal buat database: " . mysqli_error($conn));
}

mysqli_select_db($conn, DB_NAME);

$sql_create_users = "CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio varchar(255)
)";
if(mysqli_query($conn, $sql_create_users)){
    echo "Tabel 'users' berhasil dibuat atau sudah ada.<br>";
} else { die("Gagal buat tabel users: " . mysqli_error($conn)); }

$sql_create_courses = "CREATE TABLE IF NOT EXISTS courses (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    link VARCHAR(255)
)";

if(mysqli_query($conn, $sql_create_courses)){
    echo "Tabel 'courses' berhasil dibuat atau sudah ada.<br>";
} else { die("Gagal buat tabel courses: " . mysqli_error($conn)); }

$result_users = mysqli_query($conn, "SELECT COUNT(*) FROM users");
if (mysqli_fetch_array($result_users)[0] == 0) {
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('admin', '1avc4ffj0eq4qzva', 'Aku adalah admin'), ('diozahwan', 'nxhqu1bm4uj4a', 'Aku raja cybersec'), ('ucup', '1av4xhahphcl4x', 'Aku orang paling ganteng') ('idol', 219jiamcxcdfads', 'FLAG:WebSec{ma@f_id0ruuu_k4l1an_b4ru_b4ngun_n1h}'");
    echo "Data awal untuk 'users' berhasil ditambahkan.<br>";
}

$result_courses = mysqli_query($conn, "SELECT COUNT(*) FROM courses");
if (mysqli_fetch_array($result_courses)[0] == 0) {
    mysqli_query($conn, "INSERT INTO courses (title, description, link) VALUES 
    ('SQL Injection Mastery', 'Learn to find and exploit SQLi vulnerabilities from scratch.', '#'),
    ('XSS for Pentesters', 'Master the art of Cross-Site Scripting in modern web apps.', '#'),
    ('Intro to Reverse Engineering', 'Disassemble and understand malware and software.', '#'),
    ('Binary Exploitation', 'Dive deep into buffer overflows and memory corruption.', '#'),
    ('Web Security Fundamentals', 'A complete overview of common web vulnerabilities.', '#'),
    ('Active Directory Hacking', 'Learn techniques to compromise enterprise networks.', '#')");
    echo "Data awal untuk 'courses' berhasil ditambahkan.<br>";
}

echo "<hr>Setup selesai!";
mysqli_close($conn);
?>