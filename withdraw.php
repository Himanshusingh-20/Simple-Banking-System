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

// Retrieve the amount from the POST request
$amount = $_POST['amount'];

// Retrieve user's current balance
$sql = "SELECT balance FROM accounts WHERE user_id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentBalance = $row['balance'];

    // Check if there are sufficient funds for withdrawal
    if ($currentBalance >= $amount) {
        // Update the balance with the withdrawal amount
        $newBalance = $currentBalance - $amount;

        // Update the Accounts table
        $updateSql = "UPDATE accounts SET balance = $newBalance WHERE user_id = $userId";
        $conn->query($updateSql);

        // Log the withdrawal transaction
        $logSql = "INSERT INTO transactions (user_id, type, amount, balance) VALUES ($userId, 'Withdrawal', $amount, $newBalance)";
        $conn->query($logSql);

        echo json_encode(['success' => true, 'balance' => $newBalance]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Insufficient funds']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$conn->close();
?>