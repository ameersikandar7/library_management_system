<?php
include 'db.php';
session_start();

// Ensure only admins can access this page
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Fetch the book details
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

// Handle form submission to update the book
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, isbn = ?, genre = ?, quantity = ? WHERE id = ?");
    $stmt->bind_param("ssssii", $title, $author, $isbn, $genre, $quantity, $id);

    if ($stmt->execute()) {
        $success_message = "Book updated successfully!";
    } else {
        $error_message = "Error updating book.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
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

        input[type="text"], input[type="number"] {
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
            margin-top: 10px;
        }

        .success-message {
            color: green;
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
        <h2>Edit Book</h2>
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($book['title']) ?>" required>
            <input type="text" name="author" placeholder="Author" value="<?= htmlspecialchars($book['author']) ?>" required>
            <input type="text" name="isbn" placeholder="ISBN" value="<?= htmlspecialchars($book['isbn']) ?>" required>
            <input type="text" name="genre" placeholder="Genre" value="<?= htmlspecialchars($book['genre']) ?>">
            <input type="number" name="quantity" placeholder="Quantity" value="<?= htmlspecialchars($book['quantity']) ?>" min="1" required>
            <button type="submit">Update Book</button>
        </form>
        <a href="manage_books.php" class="back-link">Back to Manage Books</a>
    </div>
</body>
</html>