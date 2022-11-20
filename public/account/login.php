<?php
session_start();
$pageTitle = 'iBuy - Login';
$pageContent = '<p>Don\'t have an account?<a href=\'register.php\'>Click here to register</a></p>
    <h1>Login</h1>
    <form action="login.php" method="POST">
    <label>Email</label> <input name="email" type="email" placeholder="john.doe@example.com"/>
    <label>Password</label> <input name="password" type="password" placeholder="password"/>
    <input name="submit" type="submit" value="Submit" />
    </form>';
$stylesheet = '../assets/ibuy.css';
require '../../layout.php';
require_once '../../functions.php';

$pdo = startDB();

if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $values = [
        'email' => $_POST['email']
    ];
    $stmt->execute($values);
    $user = $stmt->fetch();
    if (password_verify($_POST['password'], $user['password'])) {
        $_SESSION['loggedin'] = $user['user_id'];
        if ($user['admin'] === 'y') {
            $_SESSION['admin'] = 'y';
        }
        echo'<script>window.location.href = "../index.php";</script>';
        
    }
    else {
        echo '<p>Unsuccessful Login</p>';
    }
}
?>