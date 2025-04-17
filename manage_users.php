<?php
session_start();
include 'db.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_result = $conn->query("SELECT * FROM users WHERE id = $edit_id");
    $edit_user = $edit_result->fetch_assoc();

    if (isset($_POST['save'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $conn->query("UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$edit_id");
        header("Location: manage_users.php");
        exit();
    }
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
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

        form {
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #003d80;
        }
    </style>
</head>
<body>
    <header>
        <h2>Manage Users</h2>
    </header>

    <?php if (isset($_GET['edit']) && $edit_user): ?>
        <form method="post">
            <h3>Edit User</h3>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= $edit_user['name'] ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $edit_user['email'] ?>" required>
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="user" <?= $edit_user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $edit_user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit" name="save">Save Changes</button>
        </form>
    <?php else: ?>
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
                    <a href="?edit=<?= $user['id'] ?>" class="action-link">Edit</a>
                    <a href="delete_user.php?id=<?= $user['id'] ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <p style="text-align:center;"><a href="admin_dashboard.php" class="button">Back to Dashboard</a></p>
    <?php endif; ?>
</body>
</html>