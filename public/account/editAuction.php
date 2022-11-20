<?php
$pageTitle = 'iBuy - Edit Auction';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';

checkListing();
$pdo = startDB();
$listing = getListing();

$pageContent = '<h1>Edit Auction</h1>
<form action="editAuction.php?listing_id='.$listing['listing_id'].'" method="POST">
<label>Title</label> <input name="title" type="text" placeholder="'. $listing['title'] .'"/>
<label>Category</label> <select name="category" style="width:420px; margin-bottom: 10px;">'. populateCatSelect() .'</select>
<label>End Date</label> <input name="endDate" type="date"/>
<label>Description</label> <textarea name="description" style="width: 438px; height: 249px;" placeholder="'. $listing['description'] .'"></textarea>
<input name="submit" type="submit" value="Submit" style="margin-top: 10px;"/>
</form>';
require '../../layout.php';

if(isset($_POST['submit'])) {
    $stmt = $pdo->prepare('UPDATE auction SET title = :title, categoryId = :categoryId, endDate = :endDate, description = :description WHERE listing_id = :listing_id');
    $values = [
        'title' => $_POST['title'],
        'categoryId' => intval($_POST['category']),
        'endDate' => $_POST['endDate'],
        'description' => $_POST['description'],
        'listing_id' => $listing['listing_id']
    ];
    $stmt->execute($values);
    echo '<script>window.location.href = "../listing.php?listing_id='.$listing['listing_id'].'";</script>';
}

?>