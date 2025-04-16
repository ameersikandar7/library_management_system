<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM books WHERE title LIKE ?";
$searchParam = "%" . $search . "%";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search & Borrow Books</title>
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
            text-align: center;
            margin: 20px;
        }

        h2 {
            color: #0056b3;
        }

        form {
            margin-bottom: 10px;
            text-align: center;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 60%;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        button:hover {
            background-color: #003f7f;
        }

        .navigate-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
        }

        .navigate-btn:hover {
            background-color: #218838;
        }

        ul {
            list-style-type: none;
            padding: 0;
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .borrow-btn {
            text-decoration: none;
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .borrow-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header>
        <h2>Search & Borrow Books</h2>
    </header>

    <form method="GET">
        <input type="text" name="search" placeholder="Search by title" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Navigate to Borrowed Books page -->
    <a href="view_borrowed_books.php" class="navigate-btn">View Borrowed Books</a>

    <h3>Available Books</h3>
    <ul>
        <?php while ($book = $result->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($book['title']) ?> by <?= htmlspecialchars($book['author']) ?> 
                (<?= htmlspecialchars($book['quantity']) ?> available)
                <a class="borrow-btn" href="borrow.php?book_id=<?= $book['id'] ?>">Borrow</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
