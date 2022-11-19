<?php
session_start();
$pageTitle = '';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';
adminCheck();
$pageContent = '<h1> Edit Category</h1>
<form action="editCategory.php" method="POST">
<label>Name</label> <input name="name" type="text" placeholder="name"/>
<input name="submit" type="submit" value="Submit" />
</form>';
require '../../layout.php';

if (isset($_GET['category_id'])) {
    $_SESSION['cat_id'] = $_GET['category_id'];
}
else if (isset($_POST['submit'])) {
    $server = 'mysql';
	$username = 'student';
	$password = 'student';
	$schema = 'assignment1';
	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
	$stmt = $pdo->prepare('UPDATE category SET name= :cat_name WHERE category_id= :category_id');
    $values = [
        'cat_name' => $_POST['name'],
        'category_id' => $_SESSION['cat_id']
    ];
	$stmt->execute($values);
    unset($_SESSION['cat_id']);
    echo '<script>window.location.href = "adminCategories.php";</script>';
}
?>