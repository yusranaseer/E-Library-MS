<?php
 	$password = $_GET['password'];
    // Perform password hashing or encryption here.
    // Example using password_hash():
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    echo $hashedPassword;
?>