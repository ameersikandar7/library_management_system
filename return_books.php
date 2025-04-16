<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$loan_id = $_GET['loan_id'] ?? null;

if ($loan_id) {
    // Update return_date and restore quantity
    $query1 = "SELECT book_id FROM loans WHERE id = ? AND user_id = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("ii", $loan_id, $user_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $loan = $result1->fetch_assoc();

    if ($loan) {
        $book_id = $loan['book_id'];
        $query2 = "UPDATE loans SET return_date = NOW() WHERE id = ?";
        $query3 = "UPDATE books SET quantity = quantity + 1 WHERE id = ?";
        
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $loan_id);
        $stmt2->execute();

        $stmt3 = $conn->prepare($query3);
        $stmt3->bind_param("i", $book_id);
        $stmt3->execute();

        $message = "Book returned successfully!";
    } else {
        $message = "Error: Loan record not found.";
    }
} else {
    $message = "No loan ID specified!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        .message {
            font-size: 18px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .error {
            color: #dc3545;
        }

        a {
            text-decoration: none;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Return Book</h2>
    <div class="message <?= isset($loan) ? '' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
    <a href="view_borrowed_books.php">Back to Borrowed Books</a>
</body>
</html>
