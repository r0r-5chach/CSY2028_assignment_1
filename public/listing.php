<?php
session_start();
require_once '../functions.php';
$pageTitle = 'iBuy - Product Listing'; 

$listing = getListing();

$pdo = startDB();
if (isset($_POST['bidSubmit'])) {
    $stmt = $pdo->prepare('INSERT INTO bids(amount, user_id, listing_id)
    VALUES(:amount, :user_id, :listing_id)');
    $values = [
        'amount' => $_POST['bid'],
        'user_id' => $_SESSION['loggedin'],
        'listing_id' => $listing['listing_id']
    ];
    $stmt->execute($values);
}
else if (isset($_POST['reviewSubmit'])) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $values = [
        'email' => $listing['email']
    ];
    $stmt->execute($values);
    $user = $stmt->fetch();

    $stmt = $pdo->prepare('INSERT INTO review (review_user, review_date, review_contents, user_id)
    VALUES (:review_user, :review_date, :review_contents, :user_id)');
    $values = [
        'review_user' => $_SESSION['loggedin'],
        'review_date' => date('Y-m-d'),
        'review_contents' => $_POST['reviewtext'],
        'user_id' => $user['user_id']
    ];
    $stmt->execute($values);
}

$pageContent = '<h1>Product Page</h1>
<article class="product">'. populateContent($listing) .'</article>';

require '../layout.php';

checkListing();


function populateContent($listing) {
    $pdo = startDB();
    
    $stmt = $pdo->prepare('SELECT * FROM category WHERE category_id = :category_id');
    $values = [
        'category_id' => $listing['categoryId']
    ];
    $stmt->execute($values);
    $category = $stmt->fetch();

    $stmt = $pdo->prepare('SELECT MAX(amount) FROM bids WHERE listing_id = :listing_id');
    $values = [
        'listing_id' => $listing['listing_id']
    ];
    $stmt->execute($values);
    $bid = $stmt->fetch();

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $values = [
        'email' => $listing['email']
    ];
    $stmt->execute($values);
    $user = $stmt->fetch();

    $output = ' <img src="product.png" alt="product name">
    <section class="details">
        <h2>'. $listing['title'] .'</h2>
        <h3>'. $category['name'] .'</h3>
        <p>Auction created by <a href="#">'. $user['first_name'].$user['last_name'] .'</a></p> 
        <p class="price">Current bid: '. $bid['MAX(amount)'] .'</p>
        <time>Time left:'. round((strtotime($listing['endDate']) - strtotime(date('Y-m-d H:i:s')))/60/60,1 ) .' Hours</time>
        <form action="listing.php?listing_id='.$listing['listing_id'].'" class="bid" method="POST">
            <input type="number" step="0.1" name="bid" value="'. $bid['MAX(amount)'] .'" />
            <input name="bidSubmit" type="submit" value="Place Bid" />
        </form>
    </section>
    <section class="description">
    <p>'. $listing['description'] .'</p>


    </section>';

    $output .= '<section class="reviews">
        <h2>Reviews of '. $user['first_name'].$user['last_name'].' </h2>
        <ul>'. getReviews($user['user_id']) .'</ul>

        <form action="listing.php?listing_id='.$listing['listing_id'].'" method="POST">
            <label>Add your review</label> <textarea name="reviewtext"></textarea>
            <input type="submit" name="reviewSubmit" value="Add Review" />
        </form>
    </section>';

    
    if (isset($_SESSION['loggedin'])) {
        if($user['user_id'] === $_SESSION['loggedin']) {
            $output .= '<a href ="account/editAuction.php?listing_id='. $listing['listing_id'] . '">edit</a>';
        }
    }

    return $output;
}

function getReviews($user_id) {
    $pdo = startDB();
    $output = '';
    $stmt = $pdo->prepare('SELECT * FROM review WHERE user_id = :user_id');
    $values = [
        'user_id' => $user_id
    ];
    $stmt->execute($values);
    $reviews = $stmt->fetchAll();

    

    foreach ($reviews as &$review) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');
        $values = [
            'user_id' => $review['review_user']
        ];
        $stmt->execute($values);
        $user = $stmt->fetch();
        $output .= '<li><strong>'.$user['first_name'].$user['last_name'].' said </strong>'.$review['review_contents'].' <em>'. $review['review_date'] .'</em></li>';
    }

    return $output;
}

?>
//TODO: add bid history