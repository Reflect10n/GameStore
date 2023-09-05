<?php
require_once "connect.php";
session_start();
ob_start();

$_SESSION['isVerified'] =false;
$lastSales = mysqli_query($connect,"SELECT * FROM 
`Товар-заказ` LEFT JOIN `Товар` ON 
`Товар`.`Код товара` = `Товар-заказ`.`Код товара`  
ORDER BY `Товар-заказ`.`Код заказа` DESC LIMIT 3;");

$newProducts = mysqli_query($connect, 
"SELECT * FROM `Товар` ORDER BY `Дата выхода` DESC LIMIT 3;");

$dateBetween=date("Y-m-d" , strtotime("-1 months"));
$sellLeaders = mysqli_query($connect,
"SELECT `Код товара`, SUM(`Количество товара`) 
as Количество FROM `Товар-заказ` 
WHERE `Товар-заказ`.`Код заказа`
 = ANY (SELECT `Заказ`.`Код заказа` FROM `Заказ` 
  WHERE `Заказ`.`Дата и время` > $dateBetween  
  ORDER BY `Заказ`.`Дата и время` DESC) GROUP BY `Код товара` 
  ORDER BY Количество DESC LIMIT 7;" );
?>




<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/style.css">
    <title>GameStore — интернет-магазин компьютерных игр</title>
</head>
<body>
    <?php include("header.php"); ?>
    <div class="block-dropdown" style="background-color: rgba(0,0,0,0.2); position: absolute; 
    top: 0; left:0; height: 100%; width: 100%; z-index: 10; display: none;"></div>
    <main>
        <section class ="main-slider">
            <div class="wrapper">
                <input type="radio" name="point" class="wrapper_slide" id="slide1" checked>
                <input type="radio" name="point" class="wrapper_slide" id="slide2">
                <input type="radio" name="point" class="wrapper_slide"  id="slide3">
                <input type="radio" name="point" class="wrapper_slide" id="slide4">
                <div class="slider">
                    <?php 
                    $sliderItem1 = mysqli_fetch_assoc(mysqli_query($connect,
                    "SELECT * FROM `Товар` WHERE `Наименование товара` LIKE '%The Witcher 3: Wild Hunt%' LIMIT 1"));
                    ?>
                    <div class="slides slide1">
                        <div class="slider_main_item">
                        <a href="/games/product.php?id=<?php echo $sliderItem1['Код товара']?>">
                            <div class="slider_main_item-bg"
                            style="background-image: url(<?php echo $sliderItem1['Фон слайдера']?>);">
                        </div>
                        <div class="slider_main_item_desc">
                            <div class="slider_main_item_title">
                                <?php echo $sliderItem1['Наименование товара']?>
                            </div>
                            <div class="slider_main_item-price-wr">
                                <div class="slider_main_item-discount">
                                <?php echo '-'. round(100 - ($sliderItem1['Цена'] / $sliderItem1['Официальная цена'] * 100)) . '%' ?>
                                </div>
                                <div class="slider_main_item-price">
                                <span class="slider_main_item-old-price">
                                   <?php echo $sliderItem1['Официальная цена'] . " ₽" ?>
                                </span>
                                <?php echo $sliderItem1['Цена'] . " ₽" ?>
                                </div>
                                </div>
                        </div>
                        </a>
                    </div>
                </div>
                <?php 
                    $sliderItem2 = mysqli_fetch_assoc(mysqli_query($connect,
                    "SELECT * FROM `Товар` WHERE `Наименование товара` LIKE '%Counter-Strike: Global Offensive%' LIMIT 1"));
                    ?>
                    <div class="slides slide2">
                        <div class="slider_main_item">
                        <a href="/games/product.php?id=<?php echo $sliderItem2['Код товара']?>">
                                <div class="slider_main_item-bg"
                                style="background-image: url(<?php echo $sliderItem2['Фон слайдера']?>);">
                            </div>
                            <div class="slider_main_item_desc">
                                <div class="slider_main_item_title">
                                <?php echo $sliderItem2['Наименование товара']?>
                                </div>
                                <div class="slider_main_item-price-wr">
                                    <div class="slider_main_item-discount">
                                    <?php echo '-'. round(100 - ($sliderItem2['Цена'] / $sliderItem2['Официальная цена'] * 100)) . '%' ?>
                                    </div>
                                    <div class="slider_main_item-price">
                                    <span class="slider_main_item-old-price">
                                    <?php echo $sliderItem2['Официальная цена'] . " ₽" ?>
                                    </span>
                                    <?php echo $sliderItem2['Цена'] . " ₽" ?>
                                    </div>
                                    </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <?php 
                        $sliderItem3 = mysqli_fetch_assoc(mysqli_query($connect,
                        "SELECT * FROM `Товар` WHERE `Наименование товара` LIKE '%Resident Evil 2 Remake%' LIMIT 1"));
                        ?>
                    <div class="slides slide3">
                        <div class="slider_main_item">
                        <a href="/games/product.php?id=<?php echo $sliderItem3['Код товара']?>">
                                <div class="slider_main_item-bg"
                                style="background-image: url(<?php echo $sliderItem3['Фон слайдера']?>);">
                            </div>
                            <div class="slider_main_item_desc">
                                <div class="slider_main_item_title">
                                <?php echo $sliderItem3['Наименование товара']?>
                                </div>
                                <div class="slider_main_item-price-wr">
                                    <div class="slider_main_item-discount">
                                    <?php echo '-'. round(100 - ($sliderItem3['Цена'] / $sliderItem3['Официальная цена'] * 100)) . '%' ?>
                                    </div>
                                    <div class="slider_main_item-price">
                                    <span class="slider_main_item-old-price">
                                    <?php echo $sliderItem3['Официальная цена'] . " ₽" ?>
                                    </span>
                                    <?php echo $sliderItem3['Цена'] . " ₽" ?>
                                    </div>
                                    </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <?php 
                        $sliderItem4 = mysqli_fetch_assoc(mysqli_query($connect,
                        "SELECT * FROM `Товар` WHERE `Наименование товара` LIKE '%DayZ%' LIMIT 1"));
                        ?>
                    <div class="slides slide4">
                        <div class="slider_main_item">
                        <a href="/games/product.php?id=<?php echo $sliderItem4['Код товара']?>">
                                <div class="slider_main_item-bg"
                                style="background-image: url(<?php echo $sliderItem4['Фон слайдера']?>);">
                            </div>
                            <div class="slider_main_item_desc">
                                <div class="slider_main_item_title">
                                <?php echo $sliderItem4['Наименование товара']?>
                                </div>
                                <div class="slider_main_item-price-wr">
                                    <div class="slider_main_item-discount">
                                    <?php echo '-'. round(100 - ($sliderItem4['Цена'] / $sliderItem4['Официальная цена'] * 100)) . '%' ?>
                                    </div>
                                    <div class="slider_main_item-price">
                                    <span class="slider_main_item-old-price">
                                    <?php echo $sliderItem4['Официальная цена'] . " ₽" ?>
                                    </span>
                                    <?php echo $sliderItem4['Цена'] . " ₽" ?>
                                    </div>
                                    </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>	
                <div class="controls">
                    <label class="label-control" for="slide1"></label>
                    <label class="label-control" for="slide2"></label>
                    <label class="label-control" for="slide3"></label>
                    <label class="label-control" for="slide4"></label>
                </div>
                <div class="main-slider__btn-next"
                style="background-image: url('/IMG/next.png');">
                </div>
                <div class="main-slider__btn-prev"
                style="background-image: url('/IMG/prev.png');">
                </div>
                <div class="small-right"
                style="background-image: url('/IMG/smallnext.png');">
                </div>
                <div class="small-left"
                style="background-image: url('/IMG/smallprev.png');">
                </div>
            </div>
        </section>
    <div class="items_container">
        <div class="sell_leaders">
            <div class="sell_leaders_title">Лидеры продаж</div>
            <div class="sell_leaders_items">
                <?php 
                    $counter=0;
                    $productId="";
                    $productTitle="";
                    $productMiniImage="";
                    $productType="";
                    $productOfficialPrice="";
                    $productPrice="";
                while ($row = mysqli_fetch_assoc($sellLeaders))
                {
                    $counter++;
                    $sellLeaderId =$row['Код товара'];
                    $currentProduct = mysqli_fetch_assoc(
                        mysqli_query($connect, "SELECT * 
                        FROM `Товар` WHERE `Код товара` = '$sellLeaderId'"));
                        $productId=$currentProduct['Код товара'];
                        $productTitle=$currentProduct['Наименование товара'];
                        $productMiniImage=$currentProduct['МиниФон'];
                        $productType=$currentProduct['Тип товара'];
                        $productOfficialPrice=$currentProduct['Официальная цена'];
                        $productPrice=$currentProduct['Цена'];
                        ?>
                <a href="/games/product.php?id=<?php echo $productId?>" class="catalog-item">
                    <div class="catalog-item__img">
                    <img src="<?php echo $productMiniImage?>" width="220px" height="111px" alt="The Witcher 3: Wild Hunt">
                    </div>
                    <div class="catalog-item__name">
                    <p><?php echo $productTitle?></p>
                    <div class="catalog-item__info">
                    <div class="catalog-item__activation">
                    <?php if($productType == "STEAM")
                        {
                            ?>
                            <img src="/IMG/items/steam.png" width="20" alt="STEAM">
                            <?php
                        }
                            if ($productType == "GOG")
                            {
                                ?>
                            <img src="/IMG/items/gog.jpg" width="20" alt="GOG">
                            <?php
                            }
                            if ($productType == "UPLAY")
                            {
                                ?>
                                <img src="/IMG/items/uplay.jpg" width="20" alt="UPLAY">
                                <?php
                            }
                            ?>
                    </div>
                    <div class="catalog-item__genres">
                    <?php
                        $productGenres =mysqli_query($connect, 
                        "SELECT `Наименование жанра` FROM `Жанр` WHERE `Код товара`=$productId;");
                        $i=0;
                        while($genre = mysqli_fetch_assoc($productGenres))
                        {
                            if ($i!=0)
                            {
                            echo ', '. $genre['Наименование жанра'];
                            }
                            else
                            {
                            echo $genre['Наименование жанра'];
                            }
                            $i++;
                        }
                        ?>
                    </div>
                    </div>
                    </div>
                    <div class="catalog-item__price">
                    <span class="catalog-item__discount">
                    <?php echo '-'. round(100 - ($productPrice / $productOfficialPrice * 100)) . '%' ?>
                    </span>
                    <span class="catalog-item__price-span"><s class="old_price">
                    <?php echo "$productOfficialPrice ₽"?></s><?php echo " $productPrice ₽"?></span>
                    </div>
                </a>
                <?php
                }
                if ($counter != 7)
                {
                    $productId="";
                    $productTitle="";
                    $productMiniImage="";
                    $productType="";
                    $productOfficialPrice="";
                    $productPrice="";
                    $limit = 7 - $counter;
                    $addToSellLeaders=mysqli_query($connect, "SELECT * 
                    FROM `Товар` WHERE `Код товара` NOT IN 
                    (SELECT `Код товара` FROM `Товар` WHERE `Код товара` = 
                    ANY (SELECT `Код товара` FROM `Товар-заказ` 
                    GROUP BY `Код товара` ORDER BY SUM(`Количество товара`))) 
                    ORDER BY `Дата выхода` DESC LIMIT $limit;");
                    while($row = mysqli_fetch_assoc($addToSellLeaders))
                    {
                        $sellLeaderId =$row['Код товара'];
                        $currentProduct = mysqli_fetch_assoc(
                            mysqli_query($connect, "SELECT * 
                            FROM `Товар` WHERE `Код товара` = '$sellLeaderId'"));
                            $productId=$currentProduct['Код товара'];
                            $productTitle=$currentProduct['Наименование товара'];
                            $productMiniImage=$currentProduct['МиниФон'];
                            $productType=$currentProduct['Тип товара'];
                            $productOfficialPrice=$currentProduct['Официальная цена'];
                            $productPrice=$currentProduct['Цена'];
                            ?>
                    <a href="/games/product.php?id=<?php echo $productId?>" class="catalog-item">
                        <div class="catalog-item__img">
                        <img src="<?php echo $productMiniImage?>" width="220px" height="111px" alt="The Witcher 3: Wild Hunt">
                        </div>
                        <div class="catalog-item__name">
                        <p><?php echo $productTitle?></p>
                        <div class="catalog-item__info">
                        <div class="catalog-item__activation">
                        <?php if($productType == "STEAM")
                            {
                                ?>
                                <img src="/IMG/items/steam.png" width="20" alt="STEAM">
                                <?php
                            }
                                if ($productType == "GOG")
                                {
                                    ?>
                                <img src="/IMG/items/gog.jpg" width="20" alt="GOG">
                                <?php
                                }
                                if ($productType == "UPLAY")
                                {
                                    ?>
                                    <img src="/IMG/items/uplay.jpg" width="20" alt="UPLAY">
                                    <?php
                                }
                                ?>
                        </div>
                        <div class="catalog-item__genres">
                        <?php
                        $productGenres =mysqli_query($connect, 
                        "SELECT `Наименование жанра` FROM `Жанр` WHERE `Код товара`=$productId;");
                        $i=0;
                        while($genre = mysqli_fetch_assoc($productGenres))
                        {
                            if ($i!=0)
                            {
                            echo ', '. $genre['Наименование жанра'];
                            }
                            else
                            {
                            echo $genre['Наименование жанра'];
                            }
                            $i++;
                        }
                            ?>
                        </div>
                        </div>
                        </div>
                        <div class="catalog-item__price">
                        <span class="catalog-item__discount">
                        <?php echo '-'. round(100 - ($productPrice / $productOfficialPrice * 100)) . '%' ?>
                        </span>
                        <span class="catalog-item__price-span"><s class="old_price">
                        <?php echo "$productOfficialPrice ₽"?></s><?php echo " $productPrice ₽"?></span>
                        </div>
                    </a>
                    <?php
                    }
                }
                ?>
                </div>
            </div>
        <div class="sell_leaders new_sells">
            <div class="sell_leaders_title">
                Новинки
            </div>
            <div class="sell_leaders_items">
            <?php 
            $productId="";
            $productTitle="";
            $productMiniImage="";
            $productType="";
            $productOfficialPrice="";
            $productPrice="";
            while($row = mysqli_fetch_assoc($newProducts))
            {
                $productId = $row['Код товара'];
                $productTitle = $row['Наименование товара'];
                $productMiniImage = $row['МиниФон'];
                $productType = $row['Тип товара'];
                $productOfficialPrice = $row['Официальная цена'];
                $productPrice = $row['Цена'];
                ?>
                    <a href="/games/product.php?id=<?php echo $productId?>" class="catalog-item">
                    <div class="catalog-item__img">
                    <img src="<?php echo $productMiniImage?>" width="220px" height="111px">
                    </div>
                    <div class="catalog-item__name">
                    <p class="item_name"><?php echo $productTitle?></p>
                    <div class="catalog-item__info">
                    <div class="catalog-item__activation">
                        <?php if($productType == "STEAM")
                        {
                            ?>
                            <img src="/IMG/items/steam.png" width="20" alt="STEAM">
                            <?php
                        }
                            if ($productType == "GOG")
                            {
                                ?>
                            <img src="/IMG/items/gog.jpg" width="20" alt="GOG">
                            <?php
                            }
                            if ($productType == "UPLAY")
                            {
                                ?>
                                <img src="/IMG/items/uplay.jpg" width="20" alt="UPLAY">
                                <?php
                            }
                            ?>
                    </div>
                    <div class="catalog-item__genres">
                    <?php  
                        $productGenres =mysqli_query($connect, 
                        "SELECT `Наименование жанра` FROM `Жанр` WHERE `Код товара`=$productId;");
                        $i=0;
                        while($genre = mysqli_fetch_assoc($productGenres))
                        {
                            if ($i!=0)
                            {
                            echo ', '. $genre['Наименование жанра'];
                            }
                            else
                            {
                            echo $genre['Наименование жанра'];
                            }
                            $i++;
                        }
                    ?>
                    </div>
                    </div>
                    </div>
                    <div class="catalog-item__price">
                    <span class="catalog-item__discount">
                    <?php echo '-'. round(100 - ($productPrice / $productOfficialPrice * 100)) . '%' ?></span>
                    <span class="catalog-item__price-span"><s class="old_price">
                        <?php echo "$productOfficialPrice ₽"?></s><?php echo " $productPrice ₽"?>
                    </span>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
                <div class="last_sells_title">Последние продажи</div>
                <div class="sell_leaders_items">
                <?php 
                        $productId="";
                        $productTitle="";
                        $productMiniImage="";
                        $productType="";
                        $productOfficialPrice="";
                        $productPrice="";
                        while($row = mysqli_fetch_assoc($lastSales))
                        {
                            $productId = $row['Код товара'];
                            $productTitle = $row['Наименование товара'];
                            $productMiniImage = $row['МиниФон'];
                            $productType = $row['Тип товара'];
                            $productOfficialPrice = $row['Официальная цена'];
                            $productPrice = $row['Цена'];
                            ?>
                    <a href="/games/product.php?id=<?php echo $productId?>" class="catalog-item">
                        <div class="catalog-item__img">
                        <img src="<?php echo $productMiniImage?>" width="220px" height="111px" 
                        alt="Spider-Man">
                        </div>
                        <div class="catalog-item__name">
                        <p class="item_name"><?php echo $productTitle?></p>
                        <div class="catalog-item__info">
                        <div class="catalog-item__activation">
                        <?php if($productType == "STEAM")
                        {
                            ?>
                            <img src="/IMG/items/steam.png" width="20" alt="STEAM">
                            <?php
                        }
                            if ($productType == "GOG")
                            {
                                ?>
                            <img src="/IMG/items/gog.jpg" width="20" alt="GOG">
                            <?php
                            }
                            if ($productType == "UPLAY")
                            {
                                ?>
                                <img src="/IMG/items/uplay.jpg" width="20" alt="UPLAY">
                                <?php
                            }
                            ?>
                    </div>
                        <div class="catalog-item__genres">
                            <?php
                        $productGenres =mysqli_query($connect, 
                        "SELECT `Наименование жанра` FROM `Жанр` WHERE `Код товара`=$productId;");
                        $i=0;
                        while($genre = mysqli_fetch_assoc($productGenres))
                        {
                            if ($i!=0)
                            {
                            echo ', '. $genre['Наименование жанра'];
                            }
                            else
                            {
                            echo $genre['Наименование жанра'];
                            }
                            $i++;
                        }
                            ?>
                        </div>
                        </div>
                        </div>
                        <div class="catalog-item__price">
                        <span class="catalog-item__discount">
                        <?php echo '-'. round(100 - ($productPrice / $productOfficialPrice * 100)) . '%' ?></span>
                        <span class="catalog-item__price-span"><s class ="old_price">
                        <?php echo "$productOfficialPrice ₽"?></s><?php echo " $productPrice ₽"?>
                        </span>
                        </div>
                    </a>
                    <?php
                        }
                        ?>
    </div>
</main>
<script src="main.js"></script>
    <?php include('footer.php');?>
</body>
</html>