<?php
$enteredPassword = 'your_password'; // Password you are trying
$storedHash = 'hashed_password_from_database'; // Example hash from DB

if (password_verify($enteredPassword, $storedHash)) {
     echo "Password matches!";
} else {
     echo "Password does not match!";
}
?>