<?php
session_start();
include 'db.php'; // Ensure your database connection file is properly configured

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        $error_message = "❌ Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Library Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #cce7ff;
            align-items: center;
            justify-content: center;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }

        .illustration {
            flex: 1;
            background-color: #0056b3;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 20px;
            font-family: 'Verdana', sans-serif;
        }

        .illustration h1 {
            font-size: 40px;
            font-weight: bold;
        }

        .illustration p {
            font-size: 18px;
            font-style: italic;
        }

        .login-form {
            flex: 1;
            background-color: white;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .message {
            color: red;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-button:hover {
            background-color: #003f7f;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="illustration">
            <h1>📚 Library Management System</h1>
            <p>Your gateway to endless knowledge! 🌟</p>
        </div>
        <div class="login-form">
            <h2>🔑 Sign in to Get Started</h2>
            <?php if (isset($error_message)): ?>
                <div class="message"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="📧 Email" class="input-field" value="<?= htmlspecialchars($email ?? '') ?>" required>
                <input type="password" name="password" placeholder="🔒 Password" class="input-field" value="<?= htmlspecialchars($password ?? '') ?>" required>
                <button type="submit" class="login-button">🚀 Login</button>
            </form>
        </div>
    </div>
</body>
</html>