<?php
header('Access-Control-Allow-Origin: http://127.0.0.1:5500'); // Live Server address
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost'; // Database host
$dbname = 'budget';  // Database name
$username = 'root';  // Database username
$password = 'JiaBao1220!'; // Database password

try {
    // Create a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get data from the POST request
    $budget_amount = isset($_POST['budget_amount']) ? $_POST['budget_amount'] : null;
    $budget_month = isset($_POST['budget_month']) ? $_POST['budget_month'] : null;

    // Check if data is valid
    if ($budget_amount !== null && $budget_month !== null) {
        // Format the budget month as YYYY-MM-DD (set to the first day of the selected month)
        $budget_month_date = $budget_month . '-01';

        // Insert budget into the database
        $stmt = $pdo->prepare("INSERT INTO budgets (budget_amount, budget_month) VALUES (:budget_amount, :budget_month)");
        $stmt->execute([
            ':budget_amount' => $budget_amount,
            ':budget_month' => $budget_month_date
        ]);
        
        // Return success message
        echo json_encode(['success' => true, 'message' => 'Budget saved successfully.']);
    } else {
        // Return error message
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} catch (PDOException $e) {
    // Catch exceptions and return error message
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
