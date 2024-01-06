<?php
// Include your database connection code here
include('dbcon.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: *");


    $user = (int)$_GET['user'];
    $password = $_GET['pwd'];
    // Fetch the hashed password associated with the given username from your Firestore

    $query = $firestore->collection('User')->where('userID', '=', $user);
    $documents = $query->documents();
    
    $verificationResult = 0; // Default to failure
    
    foreach ($documents as $document) {
        $row = $document->data();
        $encryptedPassword = $row["password"];

        $verify = password_verify($password, $encryptedPassword);

        if ($verify) {
            $verificationResult = 1; // Password is correct
            break; // Exit the loop when a matching user is found
        }
    }
    
    // Return the verification result after the loop
    echo $verificationResult;

?>
