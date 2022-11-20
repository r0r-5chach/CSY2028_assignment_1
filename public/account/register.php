<?php
require_once '../../functions.php';

$pageTitle = 'iBuy - Register';
$pageContent = '<p>Already have an account?<a href=\'login.php\'>Click here to Login</a></p>
    <h1>Register</h1>
    <form action="register.php" method="POST">
    <label>First Name</label> <input name="first_name" type="text" placeholder="John"/>
    <label>Last Name</label> <input name="last_name" type="text" placeholder="Doe"/>
    <label>Email</label> <input name="email" type="email" placeholder="john.doe@example.com"/>
    <label>Password</label> <input name="password" type="password" placeholder="password"/>
    <input name="submit" type="submit" value="Submit" />
    </form>';
    
require '../../layout.php';

if (isset($_POST['submit'])) {
    addUser(false);
    echo '<p>Successful account creation</p>';
}
?>