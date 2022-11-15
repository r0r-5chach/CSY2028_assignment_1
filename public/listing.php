<?php
$pageTitle = 'iBuy - Product Listing'; 
//TODO: have page populate information based on listing in the database
$pageContent = '<h1>Product Page</h1>
<article class="product">'. populateContent() .'</article>';

require '../layout.php';



function populateContent() {
    $server = 'mysql';
    $username = 'student';
    $password = 'student';
    $schema = 'ibuy';
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
    $stmt = $pdo->prepare('SELECT * FROM listings WHERE listing_id= :listing_id');
    $values = [
        'listing_id' => $_GET['listing_id']
    ];

    $stmt->execute($values);
    $listing = $stmt->fetch();

    $output = ' <img src="product.png" alt="product name">
    <section class="details">
        <h2>'. $listing['listing_name'] .'</h2>
        <h3>'. $listing['listing_category'] .'</h3>
        <p>Auction created by <a href="#">User.Name</a></p> 
        <p class="price">Current bid: £123.45</p>
        <time>Time left:'. (strtotime($listing['listing_deadline']) - strtotime(date('Y-m-d H:i:s')))/60 .'</time>
        <form action="#" class="bid">
            <input type="text" name="bid" placeholder="Enter bid amount" />
            <input type="submit" value="Place bid" />
        </form>
    </section>
    <section class="description">
    <p>'. $listing['listing_description'] .'</p>


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

    return $output;
}
?>