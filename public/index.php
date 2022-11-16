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

$pageContent = '<h1>'.$pageHeading.'</h1>
<ul class="productList">'.populateList($pageHeading).'</ul>';
require '../layout.php';


function populateList($category) { //TODO: This will need to be updated to populate from the database
    $output = '';
    $server = 'mysql';
	$username = 'student';
	$password = 'student';
	$schema = 'ibuy';
	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);

    if ($category === 'Latest Listings') {
        $stmt = $pdo->prepare('SELECT * FROM auction WHERE endDate > "'. date("Y-m-d H:i:s"). '" ORDER BY endDate DESC');
        $stmt->execute();
        $listings = $stmt->fetchAll();
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
        $stmt = $pdo->prepare('SELECT MAX(amount) FROM bids WHERE listing_id = :listing_id');
        $values = [
            'listing_id' => $listing['listing_id']
        ];
        $stmt->execute($values);

        $output .= '<li>
        <img src="assets/product.png" alt="product name">
        <article>
            <h2>'. $listing['name'] .'</h2>
            <h3>'. $listing['categoryId'] .'</h3>
            <p>'. $listing['description'] .'</p>
            <p class="price">Current bid:'. $stmt->fetch()['MAX(amount)'] .'</p>
            <a href="listing.php?listing_id='. $listing['listing_id'] .'" class="more auctionLink">More &gt;&gt;</a>
        </article>
        </li>';
    }


    
    return $output;
}
?>