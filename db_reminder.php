<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

$servername = "localhost"; 
$username = "root"; 
$password = "JiaBao1220!"; 
$dbname = "reminder"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "Connected to database: " . $database; 
}

?>
