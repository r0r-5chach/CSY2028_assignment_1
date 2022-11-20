<?php
session_start();
require_once '../functions.php';
$pageTitle = 'iBuy - Product Listing'; 
$pageContent = '<h1>Product Page</h1>
<article class="product">'. populateContent() .'</article>';

require '../layout.php';

if (!isset($_GET['listing_id'])) {
    echo '<script>window.location.href = "index.php";</script>';
}

function populateContent() {
    $pdo = startDB();
    
    $stmt = $pdo->prepare('SELECT * FROM auction WHERE listing_id= :listing_id');
    $values = [
        'listing_id' => $_GET['listing_id']
    ];
    $stmt->execute($values);
    $listing = $stmt->fetch();
    
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
        <time>Time left:'. round((strtotime($listing['endDate']) - strtotime(date('Y-m-d H:i:s')))/60,1 ) .' Minutes</time>
        <form action="#" class="bid">
            <input type="text" name="bid" placeholder="Enter bid amount" />
            <input type="submit" value="Place bid" />
        </form>
    </section>
    <section class="description">
    <p>'. $listing['description'] .'</p>


    </section>

    <section class="reviews">
        <h2>Reviews of User.Name </h2>
        <ul>
            <li><strong>Ali said </strong> great ibuyer! Product as advertised and delivery was quick <em>29/09/2019</em></li>
            <li><strong>Dave said </strong> disappointing, product was slightly damaged and arrived slowly.<em>22/07/2019</em></li>
            <li><strong>Susan said </strong> great value but the delivery was slow <em>22/07/2019</em></li>

        </ul>

        <form>
            <label>Add your review</label> <textarea name="reviewtext"></textarea>

            <input type="submit" name="submit" value="Add Review" />
        </form>
    </section>';

    if($user['user_id'] === $_SESSION['loggedin']) {
        $output .= '<a href ="account/editAuction.php?listing_id='. $listing['listing_id'] . '">edit</a>';
    }

    return $output;
}
?>
//TODO: add functionality for bid form
//TODO: add functionality for review form
//TODO: add bid history