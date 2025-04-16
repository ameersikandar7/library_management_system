<?php
include 'db.php'; // Ensure your database connection is included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $name = $_POST['name'];
     $email = $_POST['email'];
     $role = $_POST['role']; // 'admin' or 'user'
     $password = $_POST['password'];

     // Hash the password
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

     // Insert the hashed password into the database
     $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
     $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

     if ($stmt->execute()) {
         echo "User registered successfully!";
     } else {
         echo "Error: " . $stmt->error;
     }
}
?>
<form method="POST">
     Name: <input type="text" name="name" required><br>
     Email: <input type="email" name="email" required><br>
     Password: <input type="password" name="password" required><br>
     Role: 
     <select name="role">
         <option value="user">User</option>
         <option value="admin">Admin</option>
     </select><br>
     <button type="submit">Register</button>
</form>