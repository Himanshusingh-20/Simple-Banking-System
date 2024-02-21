<?php 
require_once('db.php');

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id']) || !isset($_SESSION['access_token'])) {
    // Redirect to the login page if not authenticated
    header('Location: bankerlogin.html');
    exit();
}

// Retrieve the user ID from the session
$userId = $_SESSION['user_id'];

// Fetch banker details
$sql = "SELECT * FROM users WHERE user_id = $userId";
$result = $conn->query($sql);

// Check if the query executed successfully
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Check if there are any results for banker details
$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

// Fetch customer accounts
$sqls = "SELECT * FROM users 
         JOIN accounts ON users.user_id = accounts.user_id 
         WHERE users.user_type = 'customer'";
$results = $conn->query($sqls);

// Check if the query executed successfully
if (!$results) {
    die("Query failed: " . $conn->error);
}

// Check if there are any results for customer accounts
$rows1 = [];
if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
        $rows1[] = $row;
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
        h4 {
            text-align: center;
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
        #transactionTable {
    border-collapse: collapse;
    width: 100%;
}

#transactionTable, th, td {
    border: 1px solid black;
}

    </style>
</head>
<body>

    <header>
        <img src="img/bank.png" alt="Bank Logo" width="80">
        <h2>Banking System</h2>
        <h4> <a href="bankerlogin.html">Logout</a></h4>
    </header>

    <main>
        <div class="container">
            
        <img src="img/No_image.jpg" height="90"width="90">
        <h2>Welcome, <?php echo isset($rows[0]["username"]) ? $rows[0]["username"] : ''; ?></h2>
        <h3>Position: <?php echo isset($rows[0]["user_type"]) ? $rows[0]["user_type"] : ''; ?></h3>
       <h4 >Account Holders Details </h4>
        <?php if (empty($rows1)) : ?>
                <p>No transactions available.</p>
            <?php else : ?>
                <table border="1px" >
                    <thead>
                        <tr>
                            <th>User-ID</th>
                            <th>Username</th>
                            <th>Balance</th>
                            <th>Transactions History</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows1 as $row) : ?>
                            <tr>
                                <td><?php echo $row["user_id"]; ?></td>
                                <td><?php echo $row["username"]; ?></td>
                                <td><?php echo $row["balance"]; ?></td>
                                <th> <a href="#section1">  <button onclick="openPopup(<?php echo $row["user_id"]; ?>)">View</button></a></th>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
       
            <section id="section1">
    <div id="TransactionPopup" class="popup">
        <h3>Transaction History</h3>
        <table id="transactionTable">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="transactionList">
                <!-- Transaction history will be dynamically populated here -->
            </tbody>
        </table>
        <button onclick="closePopup()">Close</button>
    </div>
</section>

<script>
    function openPopup(userId) {
        // AJAX request to fetch transaction history
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // Populate the #transactionList element with fetched data
                        let transactionList = document.getElementById('transactionList');
                        transactionList.innerHTML = ''; // Clear previous content

                        // Iterate through transactions and add them to the list
                        response.transactions.forEach(transaction => {
    let tr = document.createElement('tr');

    let tdUserId = document.createElement('td');
    tdUserId.textContent = transaction.user_id;
    tr.appendChild(tdUserId);

    let tdType = document.createElement('td');
    tdType.textContent = transaction.type;
    tr.appendChild(tdType);

    let tdAmount = document.createElement('td');
    tdAmount.textContent = transaction.amount;
    tr.appendChild(tdAmount);

    let tdBalance = document.createElement('td');
    tdBalance.textContent = transaction.balance;
    tr.appendChild(tdBalance);

    let tdDate = document.createElement('td');
    tdDate.textContent = transaction.timestamp;
    tr.appendChild(tdDate);

    document.getElementById('transactionList').appendChild(tr);
});
                        // Display the transaction popup
                        document.getElementById('TransactionPopup').style.display = 'block';
                    } else {
                        // Display error message
                        alert(response.message);
                    }
                } else {
                    // Display an error message if the request fails
                    console.error('Error:', xhr.statusText);
                }
            }
        };

        // Replace 'fetch_transactions.php' with the actual backend script
        xhr.open('POST', 'fetch_transactions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`userId=${userId}`);
    }

    function closePopup() {
        // Close the transaction popup
        document.getElementById('TransactionPopup').style.display = 'none';
    }
</script>

 
</body>
</html>