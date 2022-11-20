<?php
session_start();
//Listing display page. Display the 10 auctions finishing soonest
//Can be used for index, search page, and category listing
$pageTitle = 'iBuy - Home';

if (isset($_GET['pageHeading'])) {
    $pageHeading = $_GET['pageHeading'];
}
else {
    $pageHeading = 'Latest Listings';
}
require_once '../functions.php';

$pageContent = '<a href="account/addAuction.php">post auction</a>
<h1>'.$pageHeading.'</h1>
<ul class="productList">'.populateList($pageHeading).'</ul>';
require '../layout.php';

function populateList($category) { 
	$pdo = startDB();
    $output = '';
    if ($category === 'Latest Listings') {
        $stmt = $pdo->prepare('SELECT * FROM auction WHERE endDate > "'. date("Y-m-d H:i:s"). '" ORDER BY endDate ASC');
        $stmt->execute();
        $listings = $stmt->fetchAll();
        $count = 10;
    }
    else {
        $stmt = $pdo->prepare('SELECT * FROM auction WHERE categoryId = (SELECT category_id FROM category WHERE name = :listing_category)');
        $values = [
            'listing_category' => $category
        ];
        $stmt->execute($values);
        $listings = $stmt->fetchAll();
    }

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

        if ($category === 'Latest Listings') {
            $count -= 1;
            if ($count <= 0) {
                break;
            }
        }

    }
    return $output;
}
?>