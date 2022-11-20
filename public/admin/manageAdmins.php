<?php
session_start();
$pageTitle = 'iBuy - Admin';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';
adminCheck();
$pageContent = '<h1>Admins <a href="addAdmin.php">Add</a></h1> 
<ul>'. populateContent() .'</ul>';

require '../../layout.php';

function populateContent() {
    $output = '';
	$admins = getEveryAllMatches('users', 'admin', 'y');
    foreach ($admins as &$admin) {
        $output .= '<li>'. $admin['first_name'].$admin['last_name'] . ' <a href="editAdmin.php?admin_id='. urlencode($admin['user_id']) .'">edit</a> <a href="deleteAdmin.php?admin_id='. urlencode($admin['user_id']). '">delete</a></li>';
    }
    return $output;
}
?>