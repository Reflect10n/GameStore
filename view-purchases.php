<?php 
 require_once "connect.php";
session_start();
ob_start();

$username=$_SESSION["username"];
$redirect=$_POST["redirect"];
$orderCode=$_POST["orderCode"];

if(!isset($_SESSION['username']))
    {
        header("Location: index.php");
    }


$orderInfo = mysqli_query($connect, "SELECT * FROM `Товар-заказ` LEFT JOIN `Заказ` ON
    `Заказ`.`Код заказа` = `Товар-заказ`.`Код заказа` 
    WHERE `Товар-заказ`.`Код заказа` = '$orderCode';");
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
    <div class = "cart__inner" style="max-width:1200px">
    <div class="main__logo">
        <a class="main__logo-link" href="/index.php">
        <img src="/IMG/gamestoreClear.png" width="195">
        </a>
    </div>
    <div class="cart-header">
        <h1 class="cart-header__title">Заказ № <?php echo $orderCode?></h1>
    </div>
    <div class = "cart__content">
        <?php
        while($order = mysqli_fetch_assoc($orderInfo))
        {
            $productCode = $order['Код товара'];
            $result = mysqli_query($connect, "SELECT 
            * FROM `Товар` WHERE `Код товара` = '$productCode'");
            $row = mysqli_fetch_assoc($result);
            ?>
                    <div class="product-cart-info">
    <div class="cart-item catalog-item" style="width: 60%">
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
                        <?php echo $row['Цена'] * $order['Количество товара'] . " ₽"?></span>
                    </div>
</div>
<div class="product-count" style="margin-top: -2px"><?php echo $order['Ключи']?></div>
</div>
<?php
        }
        ?>
        <div style="margin-top: 40px;">
                <button class="btn-main btn-purchase">
                    <a href="<?php echo $redirect?>" style="color: white;">
                        Назад
                    </a>
                </button>
            </div>
</main>
</body>
</html>