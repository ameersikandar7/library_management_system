<?php
include 'db.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, isbn, genre, quantity) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $author, $isbn, $genre, $quantity);

    if ($stmt->execute()) {
        $success_message = "Book added successfully!";
    } else {
        $error_message = "Error adding book.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
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

        header h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], input[type="number"], select {
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
            margin: 10px 0;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <header>
            <h2>Add Book</h2>
        </header>
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="author" placeholder="Author" required>
            <input type="text" name="isbn" placeholder="ISBN" required>
            <input type="text" name="genre" placeholder="Genre">
            <input type="number" name="quantity" placeholder="Quantity" min="1" required>
            <button type="submit">Add Book</button>
        </form>
        <a href="admin_dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>