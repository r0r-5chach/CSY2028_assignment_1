<?php
session_start();
$pageTitle = 'iBuy - Add Auction';
$stylesheet = '../assets/ibuy.css';

if (!isset($_SESSION['loggedin'])) { //redirects if user is not logged in
    echo '<script>window.location.href = "../index.php";</script>'; //redirect
}

require_once '../../functions.php';

$pageContent = '<h1>Add auction</h1>
<form action="addAuction.php" method="POST" enctype="multipart/form-data">
<label>Title</label> <input name="title" type="text" placeholder="Auction Title"/>
<label>Category</label> <select name="category" style="width:420px; margin-bottom: 10px;">'. populateCatSelect() .'</select>
<label>End Date</label> <input name="endDate" type="date"/>
<label>Description</label> <textarea name="description" style="width: 438px; height: 249px;" placeholder="description"></textarea>
<label>Image</label> <input type="file" name="auctionImg"/>
<input name="submit" type="submit" value="Submit" style="margin-top: 10px;"/>
</form>';
require '../../layout.php';

if (isset($_POST['submit'])) {
    if(imageUpload($_POST['title'].$_POST['endDate'])) { //if the image upload is successful add auction
        $user = getFirstAllMatches('users', 'user_id', $_SESSION['loggedin']); //get the first match of an all column query

        $pdo = startDB();
        $stmt = $pdo->prepare('INSERT INTO auction (title, description, endDate, categoryId, email, imgUrl) 
        VALUES (:title, :description, :endDate, :categoryID, :email, :imgUrl)');
    
        $values = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'endDate' => $_POST['endDate'],
            'categoryID' => intval($_POST['category']),
            'email' => $user['email'],
            'imgUrl' => 'public/images/auctions/'.$_POST['title'].$_POST['endDate']
        ];
        $stmt->execute($values);
        echo '<p>Successful Post</p>';
    }
}
?>