<?php
$pageTitle = 'iBuy - Login';
$pageContent = '<p>Don\'t have an account?<a href=\'register.php\'>Click here to register</a></p>
    <h1>Login</h1>
    <form action="login.php" method="POST">
    <label>Email</label> <input name="email" type="text" />
    <label>Password</label> <input name="password" type="text" />
    <input name="submit" type="submit" value="Submit" />
    </form>';
$stylesheet = '../assets/ibuy.css';
require '../../layout.php';
$server = 'mysql';
    $username = 'student';
    $password = 'student';
    $schema = 'ibuy';
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $values = [
        'email' => $_POST['email']
    ];
    $stmt->execute($values);
    $user = $stmt->fetch();
    if (password_verify($_POST['password'], $user['password'])) {
        $_SESSION['loggedin'] = $user['user_id'];
        echo'<p>Successful login</p>';
        if ($user['admin'] === 'y') {
            $_SESSION['loggedin'] = 'y';
        }
    }
    else {
        echo '<p>Unsuccessful Login</p>';
    }
}
?>