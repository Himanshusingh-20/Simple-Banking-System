<?php
require_once('db.php');

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id']) || !isset($_SESSION['access_token'])) {
    // Redirect to the login page if not authenticated
    header('Location: customerlogin.html');
    exit();
}

// Retrieve the user ID from the session
$userId = $_SESSION['user_id'];
// Retrieve the user ID from the session
// Replace with the actual user ID
$amount = $_POST['amount']; // Assume the amount is sent via POST request

// Retrieve user's current balance
$sql = "SELECT balance FROM accounts WHERE user_id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentBalance = $row['balance'];

    // Update the balance with the deposit amount
    $newBalance = $currentBalance + $amount;

    // Update the Accounts table
    $updateSql = "UPDATE accounts SET balance = $newBalance WHERE user_id = $userId";
    $conn->query($updateSql);

    // Log the deposit transaction
    $logSql = "INSERT INTO transactions (user_id, type, amount, balance) VALUES ($userId, 'Deposit', $amount, $newBalance)";
    $conn->query($logSql);

    echo json_encode(['success' => true, 'balance' => $newBalance]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$conn->close();
?>