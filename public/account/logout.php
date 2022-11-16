<?php
session_start();
unset($_SESSION['loggedin']);
unset($_SESSION['admin']);
echo'<script>window.location.href = "../index.php";</script>';
?>