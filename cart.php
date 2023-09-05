<?php 
 require_once "connect.php";
session_start();
ob_start();


if(!isset($_SESSION['username']))
    {
        header("Location: index.php");
    }


if (isset($_POST['purchase']))
{
    $nickname = $_SESSION['username'];
    $paymentType = $_POST['payment'];
    $datetime = new DateTime();
    $actualDate = $datetime->format('Y-m-d H:i:s');
    $newOrder = mysqli_query($connect, "INSERT INTO `Заказ`(`Никнейм`,
    `Дата и время`, `Тип оплаты`)
    VALUES ('$nickname', '$actualDate', '$paymentType')");
    $getOrderId = mysqli_query($connect, "SELECT * FROM `Заказ` WHERE
    `Никнейм` = '$nickname' ORDER BY `Дата и время` DESC LIMIT 1");
    $orderId="";
    $orders = mysqli_fetch_assoc($getOrderId);
    $orderId=$orders['Код заказа'];
    $_SESSION['order']="$orderId";
    $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart']: '[]';
    $cart = json_decode($cart);
    foreach($cart as $item)
    {
    $newProductOrder = mysqli_query($connect, "INSERT INTO `Товар-заказ`
    (`Код заказа`, `Код товара`, `Количество товара`, `Ключи`)
    VALUES ($orderId, $item->productCartCode, $item->quantity, null)");
    }
    header("Location: /order.php");
}

$paymentsMethods = mysqli_query($connect, "SELECT * FROM `Способ оплаты`");
 ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>GameStore — Корзина</title>
</head>
<body>
    <main>
    <div class = "cart__inner">
    <div class="main__logo">
        <a class="main__logo-link" href="/index.php">
        <img src="/IMG/gamestoreClear.png" width="195">
        </a>
    </div>
    <div class="cart-header">
        <h1 class="cart-header__title">Корзина</h1>
    </div>
    <form method="POST">
    <div class="cart__content">
    <form method="POST" id="pay_form" name="pay_form" action="/cart">
        <?php
            $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
            $cart = json_decode($cart);
            $counter=0;
        foreach($cart as $item)
        {
            $counter++;
            $result = mysqli_query($connect, 
            "SELECT * FROM `Товар` WHERE `Код товара` = $item->productCartCode");
            $row = mysqli_fetch_assoc($result);
            ?>
                    <div class="product-cart-info">
    <div class="cart-item catalog-item">
                    <div class="catalog-item__img">
                    <img src="<?php echo $row['МиниФон']?>" width="220px" height="111px">
                    </div>
                    <div class="catalog-item__name">
                        <a href="/games/product.php?id=<?php echo $row['Код товара']?>">
                    <p class="item_name"><?php echo $row['Наименование товара']?></p>
                            </a>
                    <div class="catalog-item__info">
                    <div class="catalog-item__activation">
                    <?php if($row['Тип товара'] == "STEAM")
                        {
                            ?>
                            <img src="/IMG/items/steam.png" width="20" alt="STEAM">
                            <?php
                        }
                            if ($row['Тип товара'] == "GOG")
                            {
                                ?>
                            <img src="/IMG/items/gog.jpg" width="20" alt="GOG">
                            <?php
                            }
                            if ($row['Тип товара'] == "UPLAY")
                            {
                                ?>
                                <img src="/IMG/items/uplay.jpg" width="20" alt="UPLAY">
                                <?php
                            }
                            ?>
                    </div>
                    <div class="catalog-item__genres">
                    <?php echo $row['Регион активации']?>          
                    </div>
                    </div>
                    </div>
                    <div class="catalog-item__price">
                    <span class="catalog-item__price-span"> 
                        <?php echo $row['Цена'] * $item->quantity . " ₽"?></span>
                    </div>
</div>
</form>
<div class="plus-minus">
                    <form method="POST" action ="cart-minus.php" style="float:right; margin-left: 10px;">
                    <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <input type="hidden" name="productCartCode" value="<?php echo $item->productCartCode; ?>">
                    <button type="submit" class="plus-minus-btn minus-btn">
                    <span>-</span>
                        </button>
                    </form>
                        <div class="product-count"><?php echo $item->quantity?></div>
                    <form method="POST" action="cart-plus.php" style="float:right;">
                    <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <input type="hidden" name="productCartCode" value="<?php echo $item->productCartCode; ?>">
                    <button type="submit" class="plus-minus-btn plus-btn">
                    <span>+</span> 
                        </button>
                        </form>
                        </div>
                        </div>
<?php
        }
        if ($counter==0)
        {
            ?>
            <div style="display: flex; justify-content:center; margin-top: 20px">
            <label class ="choose-payment" style="font-size: 30px;" >Ваша корзина пуста :(</label>
            </div>
                <button class="btn-main btn-purchase" style="margin-top:60px; width:70%">
                    <a href="/index.php" style="color: white; font-size: 30px;">
                        Вернуться на главную
                    </a>
                </button>
            <?php
        }
        else
        {
        ?>
<div class="payment-info">
<label class ="choose-payment" >Способ оплаты:</label>
<label class ="summary-payment">Итого: 
    <?php 
                $orderSum = 0;
                $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
                $cart = json_decode($cart);
                foreach($cart as $item)
                {
                    $result = mysqli_query($connect, 
                    "SELECT * FROM `Товар` WHERE `Код товара` = $item->productCartCode");
                    $row = mysqli_fetch_assoc($result);
                    $orderSum = $orderSum + ($row['Цена'] * $item->quantity);
                }
    echo $orderSum . " ₽";
    ?>
</label>
</div>
<div class="payment-method">
    <?php
    $count = 0;
    while($paymentMethod = mysqli_fetch_assoc($paymentsMethods))
    {
        $count++;
        ?>
        <div class="choose-method">
<input type="radio" id="<?php echo $paymentMethod['Тип оплаты']?>" name="payment" value="
<?php echo $paymentMethod['Тип оплаты']?>" <?php if ($count==1) {
    ?>
    checked>
    <?php
}
else
{
    ?> >
    <?php
}
?>
      <label for="<?php echo $paymentMethod['Тип оплаты']?>">
      <img src="<?php echo $paymentMethod['Изображение']?>" style="width: 200px;"></label>
</div>
 <?php
    }
    ?>
</div>
<?php if ($count!=0)
{
    ?>
<button type="submit" name="purchase" class="btn-purchase">Оплатить</button>
<?php
}
?>
</form>
    </div>
    </div>
    <?php
        }
        ?>
</main>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</body>
</html>