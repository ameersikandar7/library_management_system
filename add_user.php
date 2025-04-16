<?php
include 'db.php'; // Include the database connection
session_start();

// Ensure only admins can access this page
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission to add a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        $success_message = "User added successfully!";
    } else {
        $error_message = "Error adding user.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], input[type="email"], input[type="password"], select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #003f7f;
        }

        .success-message, .error-message {
            text-align: center;
            color: green;
            margin-top: 10px;
        }

        .error-message {
            color: red;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #0056b3;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add User</h2>
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Add User</button>
        </form>
        <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>