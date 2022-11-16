<?php
session_start();
$pageTitle = 'iBuy - Admin';
$stylesheet = '../assets/ibuy.css';
if(isset($_SESSION['admin'])) {
    if($_SESSION['admin'] != 'y') {
        //echo'<script>window.location.href = "../index.php";</script>';
    }
}
else {
    //echo'<script>window.location.href = "../index.php";</script>';
}

require_once '../../db.php';
$pageContent = '<h1>Categories  <a href="addCategory.php">Add</a></h1> 
<ul>'. populateContent() .'</ul>';

require '../../layout.php';

function populateContent() {
    $output = '';
	$cats = fetchCats();
    foreach ($cats as &$cat) {
        $output .= '<li>'. $cat['category_name'] . ' <a href="editCategory.php?category_id='. urlencode($cat['category_id']) .'">edit</a> <a href="deleteCategory.php?category_id='. urlencode($cat['category_id']). '">delete</a></li>';
    }
    return $output;
}
?>