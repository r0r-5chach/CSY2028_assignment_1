<?php
function fetchCats() {
    $server = 'mysql';
	$username = 'student';
	$password = 'student';
	$schema = 'assignment1';
	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
	$stmt = $pdo->prepare('SELECT * FROM category');
	$stmt->execute();
	$cats = $stmt->fetchAll();

    return $cats;
}
?>