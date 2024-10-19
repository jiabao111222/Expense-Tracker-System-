<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow access from all origins

$servername = "localhost"; // Change as necessary
$username = "root"; // Your database username
$password = "JiaBao1220!"; // Your database password
$dbname = "budget"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "Connected to database: " . $database; // 打印数据库名称
}

?>
