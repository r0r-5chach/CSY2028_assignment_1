<?php
session_start();
unset($_SESSION['loggedin']);
header('Location: ../index.php');
echo '<p>Logged Out</p>';
?>