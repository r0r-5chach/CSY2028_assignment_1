<?php
session_start();
$pageTitle = 'iBuy - Admin';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';
adminCheck(); //checks to see if user is logged in as admin
$pageContent = '<h1>Categories  <a href="addCategory.php">Add</a></h1> 
<ul>'. populateContent() .'</ul>';

require '../../layout.php';

function populateContent() {
    $output = '';
	$cats = fetchCats(); //get all categories
    foreach ($cats as &$cat) {
        $output .= '<li>'. $cat['name'] . ' <a href="editCategory.php?category_id='. urlencode($cat['category_id']) .'">edit</a> <a href="deleteCategory.php?category_id='. urlencode($cat['category_id']). '">delete</a></li>';
    }
    return $output;
}
?>