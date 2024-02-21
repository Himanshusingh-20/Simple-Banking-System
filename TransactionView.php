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
$sql = "SELECT * FROM users JOIN transactions ON users.user_id = transactions.user_id WHERE users.user_id = $userId ORDER BY transactions.timestamp DESC
LIMIT 5";
$result = $conn->query($sql);

// Check if the query executed successfully
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Check if there are any results
$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}
 $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Page</title>
    <style>
        /* The previous styles remain unchanged */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #b2c1eb;
        }
        header {
            background-color: #4f8dc4;
            color: rgb(255, 255, 255);
           padding: 1em;
        }
        
        header h2{
            display: inline;
            padding: 20px;
            
        }
        header h4 {background-color:#008cfe ;
            color: red;
    margin-right: 10px; /* Adjust the margin as needed */
    text-align: center;
}

        footer {
            background-color: #008cfe;
            color: rgb(0, 0, 0);
            text-align: center;
            padding: 1em;
            position:relative;
            bottom: 0;
            width: 100%;
        }
        .container {
            background-color: #5993f8;
            margin: 20px;
            padding: 20px;
            display: list-item;
            overflow: hidden;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(173, 178, 222, 0.1);
        }
        table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

thead th, tbody td {
    padding: 15px;
    text-align: left;
}

thead th {
    background-color: #4f8dc4;
    color: white;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}
.button-container {
    text-align: center;
    margin-top: 20px;
}

.button-container button {
    padding: 10px 20px;
    margin: 0 10px;
    background-color: #333;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.button-container button:hover {
    background-color: #555;
}

        .a{
            padding: 8px;
            text-align: center;
        }
        

        .popup input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .popup button {
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <header>
        <img src="img/bank.png" alt="Bank Logo" width="80">
        <h2>Banking System</h2>
        <h4> <a href="customerlogin.html">Logout</a></h4>
    </header>

    <main>
        <div class="container">
            
        <img src="img/No_image.jpg" height="90"width="90">
        <h2>Welcome, <?php echo isset($rows[0]["username"]) ? $rows[0]["username"] : ''; ?></h2>
        <h3>Available Balence :  <?php echo isset($rows[0]["balance"]) ? $rows[0]["balance"] : ''; ?></h3>
        <div class="button-container">
        <a href="#section1">  <button onclick="openPopup('Deposit')">Deposit</button></a>
        <a href="#section2">  <button onclick="openPopup('Withdraw')">Withdraw</button></a>
</div>

            <?php if (empty($rows)) : ?>
                <p>No transactions available.</p>
            <?php else : ?>
                <table >
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <td><?php echo $row["timestamp"]; ?></td>
                                <td><?php echo $row["type"]; ?></td>
                                <td><?php echo $row["amount"]; ?></td>
                                <td><?php echo $row["balance"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
          
            <section id="section1">
        <div id="depositPopup" class="popup">
            <h3>Deposit</h3>
            <input id="depositAmount" name="depositAmount" type="number" placeholder="Enter amount">
            <button onclick="closePopup()">Cancel</button>
            <button onclick="processDeposit()">Confirm Deposit</button>
            <div id="depositMessage" class="message"></div>
        </div></section>
        <section id="section2">
        <div id="withdrawPopup" class="popup">
            <h3>Withdraw</h3>
            <input id="withdrawAmount" name="withdrawAmount" type="number" placeholder="Enter amount">
            <button onclick="closePopup()">Cancel</button>
            <button onclick="processWithdrawal()">Confirm Withdrawal</button>
            <div id="withdrawMessage" class="message"></div>
        </div></section></div>
    </main>

    <footer>
        &copy; 2024 Banking System
    </footer>

    <script>
       
    function openPopup(type) {
        document.getElementById(`${type.toLowerCase()}Popup`).style.display = 'block';
    }

    function closePopup() {
        document.getElementById('depositPopup').style.display = 'none';
        document.getElementById('withdrawPopup').style.display = 'none';
        document.getElementById('depositAmount').value = "depositAmount";
        document.getElementById('withdrawAmount').value = "withdrawAmount";
        document.getElementById('depositMessage').innerHTML = '';
        document.getElementById('withdrawMessage').innerHTML = '';
    }

   
    function processDeposit() {
        let amount = document.getElementById('depositAmount').value;

        // Validate amount (assuming amount is a positive numeric value)
        if (isNaN(amount) || parseFloat(amount) <= 0) {
            document.getElementById('depositMessage').innerHTML = 'Invalid amount';
            return;
        }

        // AJAX request for deposit
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Process the response from the server
                    let response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // Display success message or update UI as needed
                        closePopup();
                    } else {
                        // Display error message
                        document.getElementById('depositMessage').innerHTML = response.message;
                    }
                } else {
                    // Display an error message if the request fails
                    console.error('Error:', xhr.statusText);
                }
            }
        };

        // Set up and send the request for deposit
        xhr.open('POST', 'deposit.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`type=Deposit&amount=${amount}`);
    }

    function processWithdrawal() {
        let amount = document.getElementById('withdrawAmount').value;

        // Validate amount (assuming amount is a positive numeric value)
        if (isNaN(amount) || parseFloat(amount) <= 0) {
            document.getElementById('withdrawMessage').innerHTML = 'Invalid amount';
            return;
        }

        // AJAX request for withdrawal
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Process the response from the server
                    let response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // Display success message or update UI as needed
                        closePopup();
                    } else {
                        // Display error message
                        document.getElementById('withdrawMessage').innerHTML = response.message;
                    }
                } else {
                    // Display an error message if the request fails
                    console.error('Error:', xhr.statusText);
                }
            }
        };

        // Set up and send the request for withdrawal
        xhr.open('POST', 'withdraw.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`type=Withdrawal&amount=${amount}`);
    }
</script>
 
</body>
</html>