<?php
define('db_server', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_database', 'vul_db');

$conn = mysqli_connect(db_server, db_username, db_password);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . db_database;
if (!mysqli_query($conn, $sql_create_db)) {
    die("Gagal buat database: " . mysqli_error($conn));
}

mysqli_select_db($conn, db_database);

$sql_create_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL 
)";
if (!mysqli_query($conn, $sql_create_table)) {
    die("Gagal buat tabel: " . mysqli_error($conn));
}

$result = mysqli_query($conn, "SELECT COUNT(*) FROM users");
$row = mysqli_fetch_array($result);

if ($row[0] == 0) {
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('admin', '1avc4ffj0eq4qzva')");
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('diozahwan', 'nxhqu1bm4uj4a')");
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('ucup', '1av4xhahphcl4x')");
}