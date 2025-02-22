<?php
$pageTitle = 'iBuy - Edit Auction';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';

checkListing();
$listing = getListing();

$pageContent = '<h1>Edit Auction</h1>
<form action="editAuction.php?listing_id='.$listing['listing_id'].'" method="POST" enctype="multipart/form-data">
<label>Title</label> <input name="title" type="text" placeholder="'. $listing['title'] .'"/>
<label>Category</label> <select name="category" style="width:420px; margin-bottom: 10px;">'. populateCatSelect() .'</select>
<label>End Date</label> <input name="endDate" type="date"/>
<label>Description</label> <textarea name="description" style="width: 438px; height: 249px;" placeholder="'. $listing['description'] .'"></textarea>
<label>Image</label> <input type="file" name="auctionImg"/>
<label>Delete</label> <input type="checkbox" name="delete" value = "true"/>
<input name="submit" type="submit" value="Submit" style="margin-top: 10px;"/>
</form>';
require '../../layout.php';

if(isset($_POST['submit'])) {
    $pdo = startDB();
    if(isset($_POST['delete'])) { //delete the auction if selected
        $stmt = $pdo->prepare('DELETE FROM auction WHERE listing_id = :listing_id');
        $values = [
            'listing_id' => $listing['listing_id']
        ];
        $stmt->execute($values);
        echo '<script>window.location.href = "../index.php";</script>';
    }
    if(imageUpload($_POST['title'].$_POST['endDate'])) { //if image upload is successful update the auction

        $stmt = $pdo->prepare('UPDATE auction SET title = :title, categoryId = :categoryId, endDate = :endDate, description = :description, imgUrl = :imgUrl WHERE listing_id = :listing_id');
        $values = [
            'title' => $_POST['title'],
            'categoryId' => intval($_POST['category']),
            'endDate' => $_POST['endDate'],
            'description' => $_POST['description'],
            'listing_id' => $listing['listing_id'],
            'imgUrl' => 'public/images/auctions/'.$_POST['title'].$_POST['endDate']
        ];
        $stmt->execute($values);
        echo '<script>window.location.href = "../listing.php?listing_id='.$listing['listing_id'].'";</script>'; //redirect
    }
}

?>