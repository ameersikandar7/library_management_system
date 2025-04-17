<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT loans.id, books.title, loans.borrow_date, loans.return_date 
          FROM loans 
          JOIN books ON loans.book_id = books.id 
          WHERE loans.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
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

        h2 {
            color: #0056b3;
            margin: 20px 0;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #0056b3;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f4f4f9;
        }

        a {
            text-decoration: none;
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #218838;
        }

        .return-btn {
            background-color: #ffc107;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .return-btn:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <h2>Borrowed Books</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Borrow Date</th>
            <th>Due Date</th>
            <th>Return Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($loan = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($loan['title']) ?></td>
                <td><?= htmlspecialchars($loan['borrow_date']) ?></td>
                <td><?= htmlspecialchars($loan['return_date'] ? $loan['return_date'] : 'Not returned') ?></td>
                <td><?= $loan['return_date'] ? "Returned" : "Pending" ?></td>
                <td>
                    <?php if (!$loan['return_date']): ?>
                        <a href="return_books.php?loan_id=<?= $loan['id'] ?>" class="return-btn">Return</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="user_dashboard.php">Back to Dashboard</a>
</body>
</html>
