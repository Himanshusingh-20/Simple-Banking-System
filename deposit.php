<?php
require_once('db.php');

$userId = 1; // Replace with the actual user ID
$amount = $_POST['amount']; // Assume the amount is sent via POST request

// Retrieve user's current balance
$sql = "SELECT balance FROM Accounts WHERE user_id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentBalance = $row['balance'];

    // Update the balance with the deposit amount
    $newBalance = $currentBalance + $amount;

    // Update the Accounts table
    $updateSql = "UPDATE Accounts SET balance = $newBalance WHERE user_id = $userId";
    $conn->query($updateSql);

    // Log the deposit transaction
    $logSql = "INSERT INTO Transactions (user_id, type, amount, balance) VALUES ($userId, 'Deposit', $amount, $newBalance)";
    $conn->query($logSql);

    echo json_encode(['success' => true, 'balance' => $newBalance]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$conn->close();
?>