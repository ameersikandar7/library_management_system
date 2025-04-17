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
    <title>📚 Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            background-color: #cce7ff;
            overflow: hidden;
            display: flex;
        }

        .sidebar {
            width: 220px;
            height: 100%;
            background-color: #0056b3;
            color: white;
            position: fixed;
            top: 0;
            left: -220px;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            padding: 20px;
            transition: left 0.4s ease;
        }

        .sidebar:hover {
            left: 0;
        }

        .sidebar h2 {
            margin: 0;
            padding-bottom: 20px;
            font-size: 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            margin: 10px 0;
            font-size: 16px;
            padding: 8px 12px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #003f7f;
        }

        .main-content {
            flex: 1;
            margin-left: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 40px;
        }

        .button-container {
            display: flex;
            gap: 20px;
        }

        .button {
            width: 150px;
            height: 50px;
            background: linear-gradient(180deg, #007bff, #0056b3);
            border: none;
            color: white;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transform: perspective(500px) rotateX(15deg);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            line-height: 50px;
            display: inline-block;
            text-decoration: none;
        }

        .button:hover {
            transform: perspective(500px) rotateX(0deg);
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.3);
            background: linear-gradient(180deg, #0056b3, #007bff);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Navigation</h2>
        <a href="add_book.php">Add Book</a>
        <a href="manage_books.php">Manage Books</a>
        <a href="add_user.php">Add User</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="logout.php" style="background-color: #dc3545;">Logout</a>
    </div>

    <div class="main-content">
        <h1>Welcome, Admin!</h1>
        <div class="button-container">
            <a href="add_book.php" class="button">Add Book</a>
            <a href="manage_books.php" class="button">Manage Books</a>
            <a href="add_user.php" class="button">Add User</a>
            <a href="manage_users.php" class="button">Manage Users</a>
            <a href="logout.php" class="button" style="background: linear-gradient(180deg, #dc3545, #a71c1c);">Logout</a>
        </div>
    </div>
</body>
</html>