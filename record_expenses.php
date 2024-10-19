<?php
// record_expenses.php

header('Access-Control-Allow-Origin: http://127.0.0.1:5500'); // Live Server address
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

include 'db_connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get raw input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (empty($data)) {
        echo json_encode(['success' => false, 'message' => 'No data received.']);
        exit;
    }

    // retrieve and validate form data
    $amount = isset($data['amount']) ? floatval($data['amount']) : 0;
    $category = isset($data['category']) ? trim($data['category']) : '';
    $date = isset($data['date']) ? trim($data['date']) : '';
    $description = isset($data['description']) ? trim($data['description']) : '';

    // basoc validation
    if ($amount <= 0 || empty($category) || empty($date)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Insert dt into database
    $stmt = $conn->prepare("INSERT INTO expenses (amount, category, date, description) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("dsss", $amount, $category, $date, $description);

    if ($stmt->execute()) {
        // Get the total expenses after the insertion
        $stmt_total = $conn->prepare("SELECT SUM(amount) as total FROM expenses WHERE date = ?");
        if ($stmt_total) {
            $stmt_total->bind_param("s", $date);
            $stmt_total->execute();
            $result = $stmt_total->get_result();
            $row = $result->fetch_assoc();
            $new_total = $row['total'] ?? 0;
            echo json_encode(['success' => true, 'new_total' => $new_total]);
            $stmt_total->close();
        } else {
            // If unable to retrieve total expenses, still return success
            echo json_encode(['success' => true, 'new_total' => $amount]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error recording expense: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
