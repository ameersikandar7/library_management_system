<?php
session_start();
session_destroy(); // Destroy the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
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

        .logout-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
        }

        p.success {
            color: green;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .button:hover {
            background-color: #003f7f;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2>Logout</h2>
        <p class="success">You have successfully logged out!</p>
        <a href="login.php" class="button">Go to Login Page</a>
    </div>
</body>
</html>