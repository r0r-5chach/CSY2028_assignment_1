<?php
session_start();
$pageTitle ='iBuy - Add Category';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';
adminCheck();
$pageContent = '<h1> Add Category</h1>
<form action="addCategory.php" method="POST">
<label>Name</label> <input name="name" type="text" />
<input name="submit" type="submit" value="Submit" />
</form>';
require '../../layout.php';

if (isset($_POST['submit'])) {
    $server = 'mysql';
	$username = 'student';
	$password = 'student';
	$schema = 'assignment1';
	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
	$stmt = $pdo->prepare('INSERT INTO category(name)
    VALUES(:name)');
    $values = [
        'name' => $_POST['name']
    ];
	$stmt->execute($values);
    echo '<script>window.location.href = "adminCategories.php";</script>';
}