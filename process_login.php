if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password
    if ($username === 'customer' && $password === 'password') {
        // random alphanumeric 
        $accessToken = bin2hex(random_bytes(18));

         header("Location: transactions.php?token=$accessToken");
        exit();
    } else {
        echo "Invalid username or password";
    }
}
?>