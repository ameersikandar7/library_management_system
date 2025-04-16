<?php

session_start();
include 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #0056b3;
            color: white;
            padding: 15px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin: 0;
            font-size: 24px;
        }

        .dashboard-container {
            margin-top: 20px;
            text-align: center;
        }

        .button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .button:hover {
            background-color: #218838;
        }

        .button.logout {
            background-color: #dc3545;
        }

        .button.logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header>
        <h2>Admin Dashboard</h2>
    </header>
    <div class="dashboard-container">
        <a href="add_book.php" class="button">Add Book</a>
        <a href="manage_books.php" class="button">Manage Books</a>
        <a href="add_user.php" class="button">Add User</a>
        <a href="manage_users.php" class="button">Manage Users</a>
        <a href="logout.php" class="button logout">Logout</a>
    </div>
</body>
</html>