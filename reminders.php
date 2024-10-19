<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: http://127.0.0.1:5500'); // Live Server address
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Include database connection
include 'db_reminder.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Retrieve data
    $reminder_text = $input['reminder_text'] ?? '';
    $due_date = $input['due_date'] ?? '';

    // Check empty or not
    if (empty($reminder_text) || empty($due_date)) {
        echo json_encode(["success" => false, "message" => "Missing required parameters."]);
        exit;
    }

    // Insert reminder into the database
    $stmt = $conn->prepare("INSERT INTO reminders (reminder_text, due_date) VALUES (?, ?)");
    $stmt->bind_param("ss", $reminder_text, $due_date);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Reminder added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Insert error: " . $stmt->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Request method not allowed."]);
}
?>
