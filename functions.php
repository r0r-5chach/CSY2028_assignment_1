<?php
function fetchCats() {
    $pdo = startDB();
	$stmt = $pdo->prepare('SELECT * FROM category');
	$stmt->execute();
	$cats = $stmt->fetchAll();

    return $cats;
}

function adminCheck() {
	if(isset($_SESSION['admin'])) {
		if($_SESSION['admin'] != 'y') {
			echo '<script>window.location.href = "../index.php";</script>';
		}
	}
	else {
		echo'<script>window.location.href = "../index.php";</script>';
	}
}

function startDB() {
	$server = 'mysql';
	$username = 'student';
	$password = 'student';
	$schema = 'assignment1';
	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
	return $pdo;
}
?>