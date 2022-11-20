<?php
session_start();
$pageTitle = 'iBuy - Delete Admin';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';
adminCheck();

if (isset($_GET['admin_id'])) {
	$pdo = startDB();
	$stmt = $pdo->prepare('DELETE FROM users WHERE user_id= :category_id');
    $values = [
        'category_id' => $_GET['admin_id']
    ];
	$stmt->execute($values);
    echo '<script>window.location.href = "adminCategories.php";</script>';
}
else {
    echo '<script>window.location.href = "adminCategories.php";</script>';
}
?>