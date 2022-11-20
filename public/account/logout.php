<?php
session_start();
//unset variables that manage login
unset($_SESSION['loggedin']);
unset($_SESSION['admin']);
echo'<script>window.location.href = "../index.php";</script>'; //redirect
?>