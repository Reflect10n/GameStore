<?php 

$productCartCode = $_POST["productCartCode"];
$redirect = $_POST["redirect"];
$cart = isset($_COOKIE['cart']) ? $_COOKIE['cart']: '[]';
$cart = json_decode($cart);

$new_cart = array();
$i=0;
foreach($cart as $c)
{
    if ($c -> productCartCode == $productCartCode && $i!=1)
    {
        if ($c->quantity != 1)
        {
        $c->quantity -=1;
        array_push($new_cart, $c);
        $i++; 
        }   
    }
    else
    {
        array_push($new_cart, $c);
    }
}

setcookie('cart', json_encode($new_cart), time()+3600);
header("Location: $redirect");

?>