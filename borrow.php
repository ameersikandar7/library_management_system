<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = $_GET['book_id'];

$stmt = $conn->prepare("SELECT quantity FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

$message = ""; 
if ($book && $book['quantity'] > 0) {
    $conn->query("INSERT INTO loans (user_id, book_id, borrow_date) VALUES ($user_id, $book_id, NOW())");
    $conn->query("UPDATE books SET quantity = quantity - 1 WHERE id = $book_id");
    $message = "Book borrowed successfully!";
} else {
    $message = "Book not available!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Book</title>
    <style>
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

        .message-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .message {
            font-size: 18px;
            color: #333;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
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
    <div class="message-container">
        <p class="message <?= $book && $book['quantity'] > 0 ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>
        <a href="user_dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>