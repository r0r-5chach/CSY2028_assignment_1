<?php
session_start();
$pageTitle = '';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';
$admin = getFirstAllMatches('users', 'user_id', $_GET['admin_id']); //gets the first match from an all column query
adminCheck(); //checks to see if user is logged in as admin
$pageContent = '<h1> Edit Admin</h1>
<form action="editCategory.php" method="POST">
<label>First Name</label> <input name="first_name" type="text" placeholder="John"/>
<label>Last Name</label> <input name="last_name" type="text" placeholder="Doe"/>
<label>Email</label> <input name="email" type="email" placeholder="john.doe@example.com"/>
<label>Password</label> <input name="password" type="password" placeholder="password"/>
<label>Admin</label> <input type="checkbox" name="admin" value = "y"/>
<input name="submit" type="submit" value="Submit" />
</form>';
require '../../layout.php';

if (isset($_GET['admin_id'])) {
    $_SESSION['admin_id'] = $_GET['admin_id'];
}
else if (isset($_POST['submit'])) {
	$pdo = startDB();
	$stmt = $pdo->prepare('UPDATE users SET first_name= :first_name, last_name= :last_name, email= :email, password= :password, admin= :admin WHERE user_id= :category_id');

    if(isset($_POST['admin'])) {
        $values = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'admin' => $_POST['admin']
        ];
    }
    else {
        $values = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'admin' => 'n'
        ];
    }
    
	$stmt->execute($values);
    unset($_SESSION['admin_id']);
    echo '<script>window.location.href = "adminCategories.php";</script>'; //redirect
}
?>