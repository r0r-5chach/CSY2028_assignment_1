<?php
$pageTitle = 'iBuy - User Reviews';
require_once '../../functions.php';

checkId();
$user = getFirstAllMatches('users', 'user_id', $_GET['user_id']); //get the first match of an all column query

$pageContent = '<h1>'.$user['first_name'].$user['last_name'].'\'s Reviews</h1>
<ul>'. populateList() .'</ul>';
$stylesheet = '../assets/ibuy.css';
require '../../layout.php';

function populateList() {
    $reviews = getEveryAllMatches('review', 'review_user', $_GET['user_id']); //get every match of an all column query
    $output = '';

    foreach ($reviews as &$review) {
        $user = getFirstAllMatches('users', 'user_id', $review['user_id']);
        if(!$user) {
            $output .= '<li><strong>'. $review['review_date'] . '</strong> '. $review['review_contents']. '<em> reviewing Deleted</em></li>';
        } 
        else {
            $output .= '<li><strong>'. $review['review_date'] . '</strong> '. $review['review_contents']. '<em> reviewing '. $user['first_name'].$user['last_name'].'</em></li>';
        }
    }
    return $output;
}
?>