<?php
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
<ul class="productList">'.populateList().'</ul>';
require '../layout.php';

function populateList() { //TODO: This will need to be updated to populate from the database
    $output = '';
    for ($i = 0; $i <= 10; $i++) {
        $output .= '<li>
        <img src="assets/product.png" alt="product name">
        <article>
            <h2>Product name</h2>
            <h3>Product category</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sodales ornare purus, non laoreet dolor sagittis id. Vestibulum lobortis laoreet nibh, eu luctus purus volutpat sit amet. Proin nec iaculis nulla. Vivamus nec tempus quam, sed dapibus massa. Etiam metus nunc, cursus vitae ex nec, scelerisque dapibus eros. Donec ac diam a ipsum accumsan aliquet non quis orci. Etiam in sapien non erat dapibus rhoncus porta at lorem. Suspendisse est urna, egestas ut purus quis, facilisis porta tellus. Pellentesque luctus dolor ut quam luctus, nec porttitor risus dictum. Aliquam sed arcu vehicula, tempor velit consectetur, feugiat mauris. Sed non pellentesque quam. Integer in tempus enim.</p>
            <p class="price">Current bid: £123.45</p>
            <a href="listing.php" class="more auctionLink">More &gt;&gt;</a>
        </article>
    </li>';
    }
    return $output;
}
?>