<?php 
define('db_server', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_database', 'vul_db');

$conn = mysqli_connect(db_server, db_username, db_password, db_database);

if($con = false){
    die("Eror" . mysqli_connect_error());
}

$sql_create_db = "CREATE DATABASE IF NOT EXISTS" . db_database;
if(!mysqli_query($conn, $sql_create_db)) {

}

mysqli_select_db($conn, db_database);

$sql_create_table = "CREATE TABLE IF NOT EXISTS user (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL 
)";

if(!mysqli_query($conn, $sql_create_table)) {

}

$result = mysqli_query($conn, "SELECT COUNT(*) FROM user");
$row = mysqli_fetch_array($result);

if($row[0] == 0) {
    mysqli_query($conn, "INSERT INTO user (username, pasword) VALUES ('adminberjaya', '2<F}x882')");
    mysqli_query($conn, "INSERT INTO user (username, pasword) VALUES ('diozahwan', '2<F;@>@<')");
    mysqli_query($conn, "INSERT INTO user (username, pasword) VALUES ('ucup', '2<F;F82;@>@<')");
}
?>