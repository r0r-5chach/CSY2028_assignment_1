<?php
require_once '../../functions.php';

function addUser() {
    $pdo = startDB();

    $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, password, admin)
    VALUES (:first_name, :last_name, :email, :password, :admin)');
    $values = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'admin' => 'n',
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ];
    $stmt->execute($values);
}

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
    addUser();
    echo '<p>Successful account creation</p>';
}
?>