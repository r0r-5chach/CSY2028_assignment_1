<?php
function fetchCats() { //get all categories
	$cats = executeQueryWithoutConstraint('category','*')->fetchAll();
    return $cats;
}

function adminCheck() { //check to see if user is logged in as admin
	if(isset($_SESSION['admin'])) {
		if($_SESSION['admin'] != 'y') {
			echo '<script>window.location.href = "../index.php";</script>'; //redirect
		}
	}
	else {
		echo'<script>window.location.href = "../index.php";</script>'; //redirect
	}
}

function startDB() { //Create a db connection
	// Code for connecting to the database from https://www.sitepoint.com/re-introducing-pdo-the-right-way-to-access-databases-in-php/
	$server = 'mysql';
	$username = 'student';
	$password = 'student';
	$schema = 'assignment1';
	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
	return $pdo;
}

function checkListing() { //check if the get variables contains listing_id
	if (!isset($_GET['listing_id'])) {
		echo '<script>window.location.href = "index.php";</script>';
	}
}

function checkId() { //check if the get variables contains user_id
	if (!isset($_GET['user_id'])) {
		echo '<script>window.location.href = "index.php";</script>';
	}
}

function getListing() { //get listing that matches listing_id stored in the get variables
	return getFirstAllMatches('auction', 'listing_id', $_GET['listing_id']);
}

function populateCatSelect() { //Populate a select input with all categories
    $cats = fetchCats();
    $output = '';
	foreach ($cats as &$cat) {
	    $output .= '<option value="'. $cat['category_id'] .'">'. $cat['name'] .'</option>';
    }
    return $output;
}

function executeQuery($tableName, $colName, $constraintCol, $constraint) { //execute a SELECT query that takes one constraint and one column name
	$pdo = startDB();
	$stmt = $pdo->prepare('SELECT '. $colName .' FROM '.$tableName.' WHERE '. $constraintCol .' = :constraint');
	$values = [
		'constraint' => $constraint
	];
	$stmt->execute($values);
	return $stmt;
}

function executeQueryWithoutConstraint($tableName, $colName) { //execute a SELECT query with no constraint and one column name
	$pdo = startDB();
	$stmt = $pdo->prepare('SELECT'.$colName.'FROM '.$tableName);
	$stmt->execute();
	return $stmt;
}

function getFirstMatch($tableName, $colName, $constraintCol, $constraint){ //return the first match of an executeQuery
	return executeQuery($tableName, $colName, $constraintCol, $constraint)->fetch();
}

function getEveryMatch($tableName, $colName, $constraintCol, $constraint){ //return every match of an executeQuery
	return executeQuery($tableName, $colName, $constraintCol, $constraint)->fetchAll();
}

function executeAllQuery($tableName, $constraintCol, $constraint) { //execute a SELECT query with one constraint and all columns
	return executeQuery($tableName, '*', $constraintCol, $constraint);
}

function getEveryAllMatches($tableName, $constraintCol, $constraint) { //return every match of an executeALlQuery
	return executeAllQuery($tableName, $constraintCol, $constraint)->fetchAll();
}

function getFirstAllMatches($tableName, $constraintCol, $constraint) { //return the first match of an executeAllQuery
	return executeAllQuery($tableName, $constraintCol, $constraint)->fetch();
}

function imageUpload($name) { //Code for uploading an image. Modified from https://www.w3schools.com/php/php_file_upload.asp
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

function addUser($adminFlag) {
    $pdo = startDB();

    $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, password, admin)
    VALUES (:first_name, :last_name, :email, :password, :admin)');
	if ($adminFlag) {
		$values = [
        	'first_name' => $_POST['first_name'],
        	'last_name' => $_POST['last_name'],
        	'email' => $_POST['email'],
        	'admin' => 'y',
        	'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    	];
	}
	else {
    	$values = [
        	'first_name' => $_POST['first_name'],
        	'last_name' => $_POST['last_name'],
        	'email' => $_POST['email'],
        	'admin' => 'n',
        	'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ];
	}
    $stmt->execute($values);
}
?>