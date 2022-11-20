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

function checkListing() {
	if (!isset($_GET['listing_id'])) {
		echo '<script>window.location.href = "index.php";</script>';
	}
}

function getListing() {
	$pdo = startDB();
    $stmt = $pdo->prepare('SELECT * FROM auction WHERE listing_id = :listing_id');
    $values = [
        'listing_id' => $_GET['listing_id']
    ];
    $stmt->execute($values);
    return $stmt->fetch();
}

function populateCatSelect() {
    $cats = fetchCats();
    $output = '';
	foreach ($cats as &$cat) {
	    $output .= '<option value="'. $cat['category_id'] .'">'. $cat['name'] .'</option>';
    }
    return $output;
}
?>