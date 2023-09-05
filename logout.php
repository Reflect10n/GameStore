<?php
session_start();
unset($_SESSION['loggedIn']);
unset($_SESSION['username']);
setcookie('cart', '', time()-3600);
$new_url = 'index.php';
header('Location: '.$new_url);
?>