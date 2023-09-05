<?php
require_once "connect.php";
session_start();

$searchableProduct = $_GET["keyword"];

$searchProduct =mysqli_query($connect, "SELECT * FROM `Товар`
 WHERE `Наименование товара` LIKE '%$searchableProduct%';");
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>GameStore — Поиск игр</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="block-dropdown" style="background-color: rgba(0,0,0,0.2); position: absolute; 
    top: 0; left:0; height: 100%; width: 100%; z-index: 10; display: none;"></div>
    <main>
    <div class="search_item sell_leaders">
            <div class="sell_leaders_title">Результаты поиска</div>
            <div class="sell_leaders_items">
            <?php 
            $productId="";
            $productTitle="";
            $productMiniImage="";
            $productType="";
            $productOfficialPrice="";
            $productPrice="";
            while($row = mysqli_fetch_assoc($searchProduct))
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
        </div>
    </main>
    <?php include('footer.php'); ?>
    <script src="main.js"></script>
    </body>
</html>