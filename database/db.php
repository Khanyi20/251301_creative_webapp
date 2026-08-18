<?php
$host = "localhost";
$dbname = "creative_app";
$dbuser = "root";
$dbpass = "";


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4",$dbuser,$dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}
?>