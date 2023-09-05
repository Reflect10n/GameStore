<?php
require_once "../connect.php";

$currentProduct =mysqli_query($connect, "SELECT * FROM `Товар` WHERE `Ссылка` 
= '/games/the-witcher-3-wild-hunt.php';");

$productId="";
$productTitle="";
$productImage="";
$productBackground="";
$productType="";
$productReleaseDate="";
$productDeveloper="";
$productOfficialPrice="";
$productPrice="";
$productDescription="";
$productMinReq="";
$productRecReq="";
$productLocalize="";
$productRegion="";
while($row = mysqli_fetch_assoc($currentProduct))
{
    $productId = $row['Код товара'];
    $productTitle = $row['Наименование товара'];
    $productImage = $row['Изображение'];
    $productBackground = $row['Фон'];
    $productType = $row['Тип товара'];
    $productReleaseDate = $row['Дата выхода'];
    $productDeveloper = $row['Разработчик'];
    $productOfficialPrice = $row['Официальная цена'];
    $productPrice = $row['Цена'];
    $productDescription = $row['Описание'];
    $productMinReq = $row['Минимальные требования'];
    $productRecReq = $row['Рекомендованные требования'];
    $productLocalize = $row['Локализация'];
    $productRegion = $row['Регион активации'];
}

$currentProductCount=mysqli_query($connect, "SELECT COUNT(1) FROM `Ключ активации` WHERE `Код товара` = 1 AND `Активирован` = 0;");
$productCount=mysqli_fetch_array($currentProductCount)[0];


$productPublisher="";
$currentProductPublisher = mysqli_query($connect, 
"SELECT * FROM `Издатель` WHERE `Код издателя` = 
(SELECT `Код издателя` FROM `Товар` WHERE `Код товара` = $productId);");
while($row = mysqli_fetch_assoc($currentProductPublisher))
{
    $productPublisher = $row['Наименование издателя'];
}

$currentProductFeatures=mysqli_query($connect, "SELECT * FROM `Особенность товара` 
WHERE `Код особенности` = ANY 
(SELECT `Код особенности` FROM `Особенность` WHERE `Код товара` = $productId);");

$currentProductGenre = mysqli_query($connect,
"SELECT * FROM `Жанр товара` WHERE `Код жанра`
= ANY (SELECT `Код жанра` FROM `Жанр` WHERE `Код товара` = 1);");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/CSS/style.css">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">
    <title>Купить <?php echo $productTitle?></title>
</head>
<body>
    <header class="main-header">
        <div class="main-header__inner">
            <a href="/index.php" class="gamestore-logo">
                <img src="/IMG/gamestore.png" width="150">
            </a>
            <button class="main-header__btn main-header__menu" onclick='showMenu()'>
                <a href="#" class="main-header__more">
                    <img src="/IMG/more.svg" width="30" >
            </button>
            <nav>
                <ul class="main-header__list">
                    <li class="main-header__item">
                        <a class="main-header_catalog main-header__btn">Каталог игр</a>
                        <ul class="catalog__list">
                            <li>
                                <a href="#" class="catalog__item"><i>Экшн</i></a>
                            </li>
                            <li>
                                <a href="#" class="catalog__item"><i>RPG</i></a>
                            </li>
                            <li>
                                <a href="#" class="catalog__item"><i>Выживание</i></a>
                            </li>
                            <li>
                                <a href="#" class="catalog__item"><i>Приключения</i></a>
                            </li>
                            <li>
                                <a href="#" class="catalog__item"><i>Стратегия</i></a>
                            </li>
                            <li>
                                <a href="#" class="catalog__item"><i>Спорт и симуляторы</i></a>
                            </li>
                            <li>
                                <a href="#" class="catalog__item"><i>Хоррор</i></a>
                            </li>
                            <li>
                                <a href="#" class="catalog__item"><i>Шутер</i></a>
                            </li>
                            <li>
                                <a href="#" class="catalog__item"><i>Все игры</i></a>
                            </li>
                        </ul>
                    </li>
                    <li class="main-header__item">
                        <a href="#" class="main-header_support main-header__btn">
                            Поддержка</a>
                    </li>
                </ul>
            </nav>
            <input name="keyword" type="text" autocomplete="off"
            oninput="lookup(this.value);" onkeyup="lookup(this.value);" 
            onfocus="this.value = (this.value == this.title) ? '' : this.value;" 
            onblur="this.value = (this.value == '') ? this.title : this.value;" 
            class="search__input" placeholder="Поиск игр" >
            <div class="main-header__right">
            <a href="#" class="main-header__btn main-header__btn--right">
                <img src="/IMG/cart.png" width="20">
            </a>
            <a href="#" class="main-header__btn main-header__btn--right">
                <img src="/IMG/private.png" width="25">
            </a>
            </div>
        </div>
        <div class="main-header__dropdown main-header__nav active">
            <nav>
            <ul class="main-header__nav-list">
            <li class="main-header__nav-item">
            <a href="#" class="main-header__nav-link catalog__item">Все игры</a>
            </li>
            <li class="main-header__nav-item">
            <a href="#" class="main-header__nav-link catalog__item">Поддержка</a>
            </li>
            <li class="main-header__nav-item">
            <a href="#" class="main-header__nav-link catalog__item">О нас</a>
            </li>
            <li class="main-header__nav-item">
            <a href="#" class="main-header__nav-link catalog__item">Пользовательское соглашение</a>
            </li>
            </ul>
            </nav>
            </div>
    </header>
    <main class="product__main-content">
        <div class="product-bg" style="background-image: url(<?php echo $productBackground?>)"></div>
        <div class="product__main container-fluid">
        <div class="product-title">
            <?php echo $productTitle?>
              </div>
        <div class="product-content">
            <div class="product-left">
            <img class="product-image" src="<?php echo $productImage?>">
            <div class="product-extra-info">
            <div class="product-advantages">
            <ul class="product-advantages-list">
            <li class="product-advantages-item product-advantages-item--available">
            Количество в наличии:
            <?php if ($productCount == 0)
            {
                ?>
                <span class="product-advantages-red"><?php echo $productCount?></span>
                <?php
            }
            else if ($productCount < 5)
            {
                ?>
                <span class="product-advantages-orange"><?php echo $productCount?></span>
                <?php 
            }
            else
            {
                ?>
                <span class="product-advantages-green"><?php echo $productCount?></span>
                <?php
            }
            ?> 
            </li>
            <li class="product-advantages-item product-advantages-item--license">
            Лицензионный ключ активации в <span class="product-advantages-green"><?php echo $productType?></span>
            </li>
            <li class="product-advantages-item product-advantages-item--license">
            Регион: <span class="product-advantages-green"> <?php echo $productRegion?> </span>
            </li>
            </ul>
            </div>
            </div>
            </div>
            <div class="product-right">
            <div class="product-header">
            <div class="product-info product_block">
                <ul class="product-info-list">
                <li class="product-info-item">
                <div class="product-info-key">
                Жанр:
                </div>
                <div class="product-info-value">
                <ul class="product-info-inner-list">
                    <?php while ($row = mysqli_fetch_assoc($currentProductGenre))
                    {
                        ?>
                        <li class="product-info-list-item">
                        <a href="#" class="product-info-link"><?php echo $row['Наименование жанра'];?>
                        </a></li>
                        <?php
                    }
                    ?>
                </ul>
                </div>
                </li>
                <li class="product-info-item">
                <div class="product-info-key">
                Русский язык:
                </div>
                <div class="product-info-value">
                <?php echo $productLocalize?>
                </div>
                </li>
                <li class="product-info-item">
                    <div class="product-info-key">
                Дата выхода:
                </div>
                <div class="product-info-value">
                <?php echo $productReleaseDate?>
                </div>
                </li>
                <li class="product-info-item">
                <div class="product-info-key">
                Издатель:
                </div>
                <div class="product-info-value">
                <a href="#" class="product-info-link product-info-link-default">                
                    <?php echo $productPublisher?></a>
                </div>
                </li>
                <li class="product-info-item">
                <div class="product-info-key">
                Разработчик:
                </div>
                <div class="product-info-value">
                <?php echo $productDeveloper?>
                </div>
                </li>
                <li class="product-info-item">
                <div class="product-info-key">
                Особенности:
                </div>
                <div class="product-info-value">
                <?php while($row = mysqli_fetch_assoc($currentProductFeatures))
                        {
                            ?>
                            <a href="#" class="product-info-link product-info-link-default">
                            <?php echo $row['Наименование особенности'];?>
                            </a>
                            <p></p>
                            <?php
                        }
                ?>
                </div>
                </li>
                </ul>
                </div>
            <div class="product-cart-block">
            <div class="product-price-block">
            <div class="product-discount">
                <?php echo '-'. round($productPrice / $productOfficialPrice * 100) . '%' ?>
            </div>
            <div class="product-price">
            <div class="product-old-price-wrapper">
            <div class="product-old-price">
            <?php echo $productOfficialPrice?> руб.
            </div>
            </div>
            <div class="product-current-price">
            <?php echo $productPrice?> <sup class="product-price-curr">руб.</sup>
            </div>
            </div>
            </div>
            <div class="product-md-block">
            <div class="product-buy-block">
            <div class="product-buy">
            <a data-link="1" data-id="7910" data-preorder="" class="product-buy-button "><span> в корзину </span></a>
            </div>
            </div>
            <div class="product-cart-block-links">
            </div>
            </div>
            </div>
            </div>
            <div class="product-description product-block">
            <h2 class="product-block-title">
            Описание
            </h2>
            <div class="product-description-content">
                <?php echo $productDescription?>
            </div>
            </div>
            <div class="product-req product-block">
            <h3 class="product-block-title">
            Системные требования
            </h3>
            <div class="sysreq-contents">
                <div class="sys-req">
                    <div class="sys-req-min">
                        <ul>
                        <strong class="sys-min">
                            <?php echo $productMinReq?>
                            </ul>
                     </div>
                    <div class="sys-req-max">
                        <ul>
                    <strong class="sys-max">
                        <?php echo $productRecReq?>
                        </ul>
                     </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
    </main>
    <footer class="main_footer">
        <div class="payments_info"> Мы принимаем следующие способы оплаты:
            <div class="payments_img">
        <img class="payments_img" src="/IMG/payments/qiwi.png">
        <img class="payments_img" src="/IMG/payments/paypal.png">
        <img class="payments_img" src="/IMG/payments/webmoney.png">
            </div>
        </div>
        <div class="company_info">
            <ul class="main-footer__list">
                <li class="main-footer__item">
                    <a href="#" class="main-footer__btn">О нас</a>
                </li>
                <li class="main-footer__item">
                    <a href="#" class="main-footer__btn">
                        Пользовательское соглашение</a>
                </li>
            </ul>
        </div>
        <div class="rights">
            Все права не защищены ©
        </div>
    </footer>
    <script src="/main.js"></script>
</body>
</html>