<?php
header("Content-Type: application/json"); // Set the response format to JSON

try {

    include 'db_reminder.php';
    
    // Query for reminders
    $reminderSql = "SELECT id, reminder_text, due_date, created_at FROM reminders";
    $reminderResult = $conn->query($reminderSql);

    $reminders = [];
    if ($reminderResult->num_rows > 0) {
        while($row = $reminderResult->fetch_assoc()) {
            $reminders[] = $row;
        }
    }
    
    // Close reminders database connection
    $conn->close();

    // Connect to the budget database
    include 'db_budget.php';
    
    // Query for budget
    $budgetSql = "SELECT id, budget_amount, budget_month FROM budgets";
    $budgetResult = $conn->query($budgetSql);

    // merge reminders and budget data into one response
    $response = [
        'reminders' => $reminders
    ];

    echo json_encode($response); 

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]); // Return an error message
}
?>
