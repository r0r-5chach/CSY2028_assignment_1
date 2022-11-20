<?php
session_start();
$pageTitle ='iBuy - Add Admin';
$stylesheet = '../assets/ibuy.css';
require_once '../../functions.php';
adminCheck(); //checks to see if user is logged in as an admin
$pageContent = '<h1> Add Admin</h1>
<form action="addAdmin.php" method="POST">
<label>First Name</label> <input name="first_name" type="text" placeholder="John"/>
<label>Last Name</label> <input name="last_name" type="text" placeholder="Doe"/>
<label>Email</label> <input name="email" type="email" placeholder="john.doe@example.com"/>
<label>Password</label> <input name="password" type="password" placeholder="password"/>
<input name="submit" type="submit" value="Submit" />
</form>';
require '../../layout.php';

if (isset($_POST['submit'])) {
	addUser(true); //adds user to the db with admin privileges
    echo '<script>window.location.href = "manageAdmins.php";</script>'; //redirect
}
?>