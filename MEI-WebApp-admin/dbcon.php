<?php
require __DIR__.'/vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;

// Initialize Firestore
$firestore = new FirestoreClient([
    'keyFilePath' => 'Keys/mecdb-ba6be-033d6216f407.json',
    'projectId' => 'mecdb-ba6be',
]);						
?>

