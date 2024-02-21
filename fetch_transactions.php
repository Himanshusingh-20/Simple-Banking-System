<?php
// fetch_transactions.php

require_once('db.php');

// Retrieve userId from the AJAX request
$userId = $_POST['userId'];

// Fetch transaction history for the specified userId
$sql = "SELECT * FROM transactions
JOIN accounts ON transactions.user_id = accounts.user_id
WHERE transactions.user_id = $userId";
$result = $conn->query($sql);

if ($result) {
    $transactions = [];

    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }

    echo json_encode(['success' => true, 'transactions' => $transactions]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error fetching transactions']);
}

$conn->close();
?>