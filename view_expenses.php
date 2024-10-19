<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

// Database configuration
$servername = "localhost";
$username = "root"; 
$password = "JiaBao1220!"; 
$dbname = "expenses";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query data from the database
$sql = "SELECT id, amount, category, date, description FROM expenses";
$result = $conn->query($sql);


$logs = array();

// Store the query results in an array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

// Close the connection
$conn->close();

// Return data in JSON format
echo json_encode($logs);
?>

