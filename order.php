<?php 
 require_once "connect.php";
session_start();
ob_start();
$currentOrder = $_SESSION['order'];

if(!isset($_SESSION['username']))
    {
        header("Location: index.php");
    }
 ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>Заказ — успешно</title>
</head>
<body>
    <main>
        <div class ="order-content">
        <div class="cart-header">
        <h1 class="cart-header__title"><?php echo "Заказ № " . $currentOrder?></h1>
    </div>
            <div class = "order-container">
            <?php 
            $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart']: '[]';
            $cart = json_decode($cart);
            foreach($cart as $item)
            {
            $result = mysqli_query($connect, 
            "SELECT * FROM `Товар` WHERE `Код товара` = $item->productCartCode");
            $row = mysqli_fetch_assoc($result);
            $keys= mysqli_query($connect,
            "SELECT * FROM `Ключ активации` WHERE `Код товара` = $item->productCartCode
            AND `Активирован` = 0 LIMIT $item->quantity;");
            ?>
                    <div class="order-item">
                    <div class="order-item-info">
                    <div class="order-item-img">
                        <img src="
                       <?php echo $row['МиниФон'];?>">
                    </div>
                    <div class="order-item-title">
                        <b><?php echo $row['Наименование товара']?></b>
                    </div>
                    </div>
                    <div class="order-item-keys">
                        <?php
                        $allKeys="";
                        while($key=mysqli_fetch_assoc($keys))
                        {
                            $actualKey=$key['Ключ'];
                            $allKeys=$allKeys . "<br>" . $actualKey . "<br>";
                            ?>
                            <div class="item-key">
                                <?php echo $actualKey;
                            ?>
                                    </div>
                                    <?php
                            mysqli_query($connect, "UPDATE `Ключ активации` SET
                            `Активирован` = 1 WHERE `Ключ` = '$actualKey'");
                        }
                        mysqli_query($connect, "UPDATE `Товар-заказ` 
                        SET `Ключи` = '$allKeys' 
                        WHERE (`Код заказа` = '$currentOrder') AND 
                        (`Код товара` = $item->productCartCode);");
                        ?>
                        </div>
                        </div>
                        <?php
            }
            setcookie('order','',time()-3600);
            setcookie('cart', '', time()-3600);
        ?>
        <div style="margin-top: 40px;">
                <p style="font-size: 18px">Не забудьте оставить отзыв</p>
                <button class="btn-main btn-purchase">
                    <a href="/index.php" style="color: white;">
                        На главную
                    </a>
                </button>
            </div>
    </main>
</body>
