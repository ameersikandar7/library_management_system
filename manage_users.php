<?php
include 'db.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users from the database
$result = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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

        table {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0056b3;
            color: white;
        }

        tr:hover {
            background-color: #f4f4f9;
        }

        .action-link {
            text-decoration: none;
            color: #0056b3;
            margin-right: 10px;
        }

        .action-link:hover {
            text-decoration: underline;
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
    </style>
</head>
<body>
    <header>
        <h2>Manage Users</h2>
    </header>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['role'] ?></td>
            <td>
                <a href="edit_user.php?id=<?= $user['id'] ?>" class="action-link">Edit</a>
                <a href="delete_user.php?id=<?= $user['id'] ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p style="text-align:center;"><a href="admin_dashboard.php" class="button">Back to Dashboard</a></p>
</body>
</html>