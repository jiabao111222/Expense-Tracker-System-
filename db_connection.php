<?php
$servername = "localhost"; // Change as necessary
$username = "root"; // Your database username
$password = "JiaBao1220!"; // Your database password
$dbname = "expenses"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "Connected to database: " . $database; // 
}

?>
