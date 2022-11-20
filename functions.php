<?php
function fetchCats() {
    $pdo = startDB();
	$stmt = $pdo->prepare('SELECT * FROM category');
	$stmt->execute();
	$cats = executeQueryWithoutConstraint('category','*')->fetchAll();

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
	return getFirstAllMatches('auction', 'listing_id', $_GET['listing_id']);
}

function populateCatSelect() {
    $cats = fetchCats();
    $output = '';
	foreach ($cats as &$cat) {
	    $output .= '<option value="'. $cat['category_id'] .'">'. $cat['name'] .'</option>';
    }
    return $output;
}

function executeQuery($tableName, $colName, $constraintCol, $constraint) {
	$pdo = startDB();
	$stmt = $pdo->prepare('SELECT '. $colName .' FROM '.$tableName.' WHERE '. $constraintCol .' = :constraint');
	$values = [
		'constraint' => $constraint
	];
	$stmt->execute($values);
	return $stmt;
}

function executeQueryWithoutConstraint($tableName, $colName) {
	$pdo = startDB();
	$stmt = $pdo->prepare('SELECT'.$colName.'FROM '.$tableName);
	$stmt->execute();
	return $stmt;
}

function getFirstMatch($tableName, $colName, $constraintCol, $constraint){
	return executeQuery($tableName, $colName, $constraintCol, $constraint)->fetch();
}

function getEveryMatch($tableName, $colName, $constraintCol, $constraint){
	return executeQuery($tableName, $colName, $constraintCol, $constraint)->fetchAll();
}

function executeAllQuery($tableName, $constraintCol, $constraint) {
	return executeQuery($tableName, '*', $constraintCol, $constraint);
}

function getEveryAllMatches($tableName, $constraintCol, $constraint) {
	return executeAllQuery($tableName, $constraintCol, $constraint)->fetchAll();
}

function getFirstAllMatches($tableName, $constraintCol, $constraint) {
	return executeAllQuery($tableName, $constraintCol, $constraint)->fetch();
}

function imageUpload($name) {
	$imgDir = 'public/images/auctions/';
	$file = $imgDir . $name;
	$okFlag = true;
	$fileType = strtolower($_FILES['auctionImg']['type']);

	//check if file is actually an image
	if(isset($_POST['submit'])) {
		$sizeCheck = getimagesize($_FILES['auctionImg']['tmp_name']);
		if (!$sizeCheck) {
			$okFlag = false;
            echo 'not an image';
		}
	}

	//check if file exists
	if(file_exists($file)) {
		$okFlag = false;
        echo 'already exists';
	}

	if($_FILES['auctionImg']['size'] > 10000000) {
		$okFlag = false;
        echo 'too big';
	}

	//check filetypes
	$types = array('image/jpg','image/png','image/jpeg','image/gif');
	if(!in_array($fileType, $types)) {
		$okFlag = false;
        echo 'wrong type';
	}

	if($okFlag) {
		if (move_uploaded_file($_FILES['auctionImg']['tmp_name'], '../../'.$file)) {
			return true;
		}
		else {
			echo '<p>There was an error uploading your image</p>';
			return false;
		}
	}
	else {
		echo '<p>There was an error uploading your image</p>';
        return false;
	}
}
?>