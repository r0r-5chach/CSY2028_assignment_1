<?php
session_start();
$pageTitle = 'iBuy - Delete Category';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';
adminCheck();

if (isset($_GET['category_id'])) {
    $server = 'mysql';
	$username = 'student';
	$password = 'student';
	$schema = 'assignment1';
	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
	$stmt = $pdo->prepare('DELETE FROM category WHERE category_id= :category_id');
    $values = [
        'category_id' => $_GET['category_id']
    ];
	$stmt->execute($values);
    echo '<script>window.location.href = "adminCategories.php";</script>';
}
else {
    echo '<script>window.location.href = "adminCategories.php";</script>';
}
?>