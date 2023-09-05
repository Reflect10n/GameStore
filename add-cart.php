<?php
ob_start();
require_once "connect.php";
$productCartCode = $_POST['productCartCode'];
$quantity = $_POST['quantity'];

$cart = isset($_COOKIE['cart']) ? $_COOKIE['cart']: '[]';
$cart = json_decode($cart);


array_push($cart, array(
    "productCartCode" => $productCartCode,
    "quantity" => $quantity
));

setcookie('cart', json_encode($cart), time()+2600);
header("Location: /games/product.php?id=$productCartCode");

?>