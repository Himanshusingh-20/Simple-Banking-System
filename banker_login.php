<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add your database connection logic here
    require_once('db.php');

    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and authenticate using prepared statements
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? AND user_type='banker' AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId);
        $stmt->fetch();

        // Authentication successful, generate access token
        $accessToken = generateAccessToken();

        // Store the access token in the database or a session variable
        // For simplicity, storing in a session variable
        session_start();
        $_SESSION['user_id'] = $userId;
        $_SESSION['access_token'] = $accessToken;

        // Redirect to the transactions page
        header("Location: bankerview.php");
        exit();
    } else {
        // Authentication failed, handle accordingly (e.g., display an error message)
        header("Location: bankerlogin.html");
    }

    $stmt->close();
    $conn->close();
}

function generateAccessToken() {
    return bin2hex(random_bytes(18));
}
?>