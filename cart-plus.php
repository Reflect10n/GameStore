<?php 
require_once "connect.php";

$productCartCode = $_POST["productCartCode"];
$redirect = $_POST["redirect"];
$cart = isset($_COOKIE['cart']) ? $_COOKIE['cart']: '[]';
$cart = json_decode($cart);

$currentProductCount=mysqli_query($connect, "SELECT COUNT(1) FROM `Ключ активации` WHERE `Код товара` = $productCartCode AND `Активирован` = 0;");
$productCount=mysqli_fetch_array($currentProductCount)[0];
$new_cart = array();
foreach($cart as $c)
{
    if ($c -> productCartCode == $productCartCode)
    {
        if (($c->quantity < $productCount) && ($c->quantity < 5))
        {
        $c->quantity++;
        }   
    }
    array_push($new_cart, $c);
}

setcookie('cart', json_encode($new_cart), time()+600);
header("Location: $redirect");

?>