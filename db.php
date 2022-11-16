<?php
function fetchCats() {
    $server = 'mysql';
	$username = 'student';
	$password = 'student';
	$schema = 'ibuy';
	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
	$stmt = $pdo->prepare('SELECT * FROM categories');
	$stmt->execute();
	$cats = $stmt->fetchAll();

    return $cats;
}
?>