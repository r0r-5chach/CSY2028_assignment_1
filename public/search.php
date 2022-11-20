<?php
session_start();
$pageTitle = 'iBuy - Search Results';
require_once '../functions.php';
$pageContent = '<h1> Search Results </h1>
<ul>'. populateResults() .'</ul>';

require '../layout.php';

function populateResults() {
    $output = '';
    $pdo = startDB();
    $stmt = $pdo->prepare('SELECT * FROM auction WHERE title LIKE "%'.$_GET['search'].'%"');
    $stmt->execute();
    $listings = $stmt->fetchAll();

    foreach ($listings as &$listing) {
        $listCat = getFirstAllMatches('category', 'category_id', $listing['categoryId'])['name'];
        $bid = getFirstMatch('bids','MAX(amount)', 'listing_id', $listing['listing_id']);

        $output .= '<li>
        <img src="'.$listing['imgUrl'].'" alt="product name">
        <article>
            <h2>'. $listing['title'] .'</h2>
            <h3>'. $listing['categoryId'] .'</h3>
            <p>'. $listing['description'] .'</p>
            <p class="price">Current bid:'. $bid['MAX(amount)'] .'</p>
            <a href="listing.php?listing_id='. $listing['listing_id'] .'" class="more auctionLink">More &gt;&gt;</a>
        </article>
        </li>';
    }

    return $output;
}