<?php
$dsn = 'mysql:host=localhost;dbname=music';
$user = 'admin';
$pass = 'pa55word';

$db = new PDO($dsn, $user, $pass);

$category = $_POST['category'];

include('empProductListing.php');
?>
