live server:- http://127.0.0.1:5500/  (only the frontend code in run through xampp)
apachi:- http://localhost/JAVASCRIPTWORK/Simple-Banking-System/
photo link :- [https://drive.google.com/drive/folders/1C2hG5sowpJ4rEr-3yWlLzP1tHbtjz6D-?usp=drive_link](https://drive.google.com/drive/folders/1C2hG5sowpJ4rEr-3yWlLzP1tHbtjz6D-?usp=sharing)
Technology:- Html, Css, JavaScript, PHP
Software:- Visual Studio Code 
           Mysql 
           Xampp 

Objective: Create a banking system utilizing PHP or Node.js along with Vue.js or
React.js, following the MVC (Model View Controller) architecture, and using MySQL
as the database.
Task Details:
1. Database Setup:
● Create a Database named 'Bank' with two tables: Users and Accounts.
● The Users table should store information about bankers and
customers.
● The Accounts table should log cash deposits and withdrawals.
2. Customer Login:
● Design a login page with fields for username/email and password.
● Generate an access token (a random alphanumeric string of 36
characters) upon successful login.
● Use the access token as a header (Authorization) for subsequent API
requests.
3. Transactions Page (For Customers):
● Upon login, customers should be directed to a transactions page.
● Display all transaction records with Deposit and Withdraw buttons.
● Clicking on either button should open a popup showing the available
balance and a numeric input field for deposit/withdrawal.
● Implement logic to deduct or add to the balance based on user input.
● Display a message ("Insufficient Funds") if the withdrawal amount
exceeds the available balance.
4. Banker Login:
● Create a separate login page for bankers.
● Upon login, bankers should be directed to an accounts page displaying
all customer accounts.
● Allow bankers to click on a specific user to view their transaction
history.
