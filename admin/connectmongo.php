<?php

require_once '../vendor/autoload.php'; 

$databaseConnection = new MongoDB\Client;  

$myDatabase = $databaseConnection->mathsquiz; 

$adminCollection = $myDatabase->admin; 
$messageCollection = $myDatabase->messages;
$userCollection = $myDatabase->users;
$questionsCollection = $myDatabase->questions;

?>