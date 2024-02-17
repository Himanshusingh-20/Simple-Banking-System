<?php
require_once('db.php');

// Assume the user is already authenticated with a valid access token
$userId = 1; // Replace with the actual user ID after authentication

// Retrieve transaction records for the user
$sql = "SELECT * FROM accounts WHERE user_id = $userId";
$result = $conn->query($sql);

$transactions = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

// Respond with transaction records in JSON format
header('Content-Type: application/json');
echo json_encode($transactions);
?>