<?php 

$productCartCode = $_POST["productCartCode"];
$redirect = $_POST["redirect"];

$cart = isset($_COOKIE['cart']) ? $_COOKIE['cart']: '[]';
$cart = json_decode($cart);

$new_cart = array();
foreach ($cart as $c)
{
    if ($c -> productCartCode != $productCartCode)
    {
        array_push($new_cart, $c);
    }
}

setcookie('cart', json_encode($new_cart), time()+3600);
header("Location: $redirect");

?>