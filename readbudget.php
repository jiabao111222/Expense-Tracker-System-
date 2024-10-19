<?php
// Set the response format to JSON
header("Content-Type: application/json");

// Handle cross-origin requests (adjust as needed)
header("Access-Control-Allow-Origin: *"); // In production, specify the allowed domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    // Connect to the budgets database
    include 'db_budget.php';
    
    // Query for budgets
    $budgetSql = "SELECT id, budget_amount, budget_month FROM budgets";
    $budgetResult = $conn->query($budgetSql);

    // Check if the query was successful
    if (!$budgetResult) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Initialize the budget array
    $budgets = [];
    if ($budgetResult->num_rows > 0) {
        while($row = $budgetResult->fetch_assoc()) {
            $budgets[] = $row;
        }
    }
    
    // Close the budgets database connection
    $conn->close();

    // Build the response data
    $response = [
        'budgets' => $budgets
    ];

    // Output JSON data
    echo json_encode($response);

} catch (Exception $e) {
    // Return error message
    echo json_encode(["error" => $e->getMessage()]);
}
?>
