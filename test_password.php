<?php
$enteredPassword = 'your_password'; 
$storedHash = 'hashed_password_from_database'; 

if (password_verify($enteredPassword, $storedHash)) {
     echo "Password matches!";
} else {
     echo "Password does not match!";
}
?>