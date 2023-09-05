<?php
require_once "../connect.php";
session_start();
ob_start();
$currentLink = $_SERVER['QUERY_STRING'];
$currentId = explode('=', $currentLink);
$currentProduct =mysqli_query($connect, "SELECT * FROM `Товар` WHERE `Код товара` 
= $currentId[1];");

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
$productPublisher="";
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
    $productPublisher = $row['Издатель'];
}

$currentProductCount=mysqli_query($connect, "SELECT COUNT(1) FROM `Ключ активации` WHERE `Код товара` = $productId AND `Активирован` = 0;");
$productCount=mysqli_fetch_array($currentProductCount)[0];


$currentProductFeatures=mysqli_query($connect, "SELECT * FROM `Особенность` 
WHERE `Код товара` = $productId");

$currentProductGenre = mysqli_query($connect,
"SELECT * FROM `Жанр` WHERE `Код товара` = $productId");


$currentProductReviews = mysqli_query($connect, 
"SELECT * FROM `Отзыв` WHERE `Код товара` = $productId ORDER BY `Дата и время` DESC;");
$username="";
$datetime="";
$text="";

if (isset($_POST['publishing'])) {
    $text = $_POST['reviewText'];
    $username = $_SESSION['username'];
    $datetime = new DateTime();
    $actualDate = $datetime->format('Y-m-d H:i:s');
    $sql = "INSERT INTO `Отзыв`(`Код товара`,`Никнейм`,`Дата и время`, `Текст отзыва`)
     VALUES ($productId,'$username', '$actualDate', '$text');";
    mysqli_query($connect, $sql);
    $new_url = "/games/product.php?id=$productId";
    header('Location: '.$new_url);
 }

 /* if (isset($_POST['addToCart'])) {
    $username = $_SESSION['username'];
    $_SESSION['stored_items'] = $currentProduct;
    $cartItems = isset($_COOKIE["cartItems"]) ? $_COOKIE["cartItems"] : "[]";
    $cartItems = json_decode($cartItems);
    array_push($cartItems, array("productItem" => $currentProduct));
    setcookie("cartItems", json_encode($cartItems));
    $new_url = '../cart.php';
    header('Location: '.$new_url);
    } */
?>


<!DOCTYPE html>
<html lang="ru">
<head>
<script src="../main.js"></script>
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
            <form action="/games.php" method="get">
            <input name="keyword" type="text" autocomplete="off"
            class="search__input" placeholder="Поиск игр" >
        </form>
        <div class="main-header__right">
                <?php
            if (!isset($_SESSION['loggedIn']))
            {
                ?>
                <button class="main-header__btn main-header__btn--right" onclick='alert("Для покупки надо сначала авторизоваться!");'>
                <img src="../IMG/cart.png" width="25"></img>
                <p style="color:red;"><?php 
                    $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart']: '[]';
                    $cart = json_decode($cart);
                    $counter=0;
                    foreach($cart as $item)
                    {
                        $counter+=$item->quantity;
                    }
                    echo "&nbsp$counter";
                ?></p>
            </button>
            <?php
            }
            else
            {
            ?>
                <a href="../cart.php" class="main-header__btn main-header__btn--right">
                <img src="../IMG/cart.png" width="25"></img>
                <p style="color:red;"><?php 
                    $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart']: '[]';
                    $cart = json_decode($cart);
                    $counter=0;
                    foreach($cart as $item)
                    {
                        $counter+=$item->quantity;
                    }
                    echo "&nbsp$counter";
                ?></p>
            </a>
            <?php 
            }
            if (!isset($_SESSION['loggedIn']))
            {
                ?>
                <a href="../authorize.php" class="registration main-header__btn main-header__btn--right">
                <img src="../IMG/private.png" width="25">
            </a>
            <?php
            }
            else
            {
                ?>
                  <nav style = "max-width = 70">
                <ul class="main-header__list">
                    <li class="main-header__item">
                    <a class="registration main-header__btn main-header__btn--right">
                <img src="../IMG/private.png" width="25"></a>
                        <ul class="catalog__list">
                            <li>
                                <a href="../profile.php" class="catalog__item"><i><?php echo $_SESSION['username']?></i></a>
                            </li>
                            <li>
                                <a href="../logout.php" class="catalog__item"><i>Выйти</i></a>
                            </li>
                            <li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <?php
            }
            ?>
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
                <div class="product-big-image">
            <img class="product-image" src="<?php echo $productImage?>">
        </div>
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
                <?php echo '-'. round(100 - ($productPrice / $productOfficialPrice * 100)) . '%' ?>
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
            <div class="product-buy" style="max-width: 300px">
            <?php 
            $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"]: "[]";
            $cart = json_decode($cart);
            $flag = false;
            if ($productCount !=0)
            {
            foreach ($cart as $c)
            {
                if ($c->productCartCode == $productId)
                {
                    $flag = true;
                    break;
                }
            }
            ?>
            <?php if ($flag) {
                ?>
                <form method="POST" action="../delete-cart.php">
                <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <input type="hidden" name="productCartCode" value="<?php echo $productId;?>">
                    <input type="submit" value="Удалить из корзины" class="product-buy-button">
                    <?php
            }
            else
            {
                if ($_SESSION["loggedIn"])
                {
            ?>
            <form method="POST" action="../add-cart.php">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="productCartCode" value="<?php echo $productId;?>">
                <iframe name="myIFR" style="display: none"></iframe>
            <input type="submit" value="В корзину" class="product-buy-button">
            <?php
            }
            else
            {
                ?>
                <input type="submit" value="Авторизуйтесь" class="product-buy-button" disabled
                style="cursor: default; background-color: grey;">
                <?php
            }
        }
    }
        else
        {
            if (!$_SESSION["loggedIn"])
            {
                ?>
                <input type="submit" value="Авторизуйтесь" class="product-buy-button" disabled
                style="cursor: default; background-color: grey;">
                <?php
            }
            else
            {
            ?>
            <input type="submit" value="Нет в наличии" class="product-buy-button" disabled
            style="cursor: default; background-color: grey;">
        <?php
            }
        }
            ?>
            </form>
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
        </div>
            <div class="product-reviews product-block">
            <div class="comments__header">
            <div class="comments__title">
                Отзывы
            </div>
            <?php 
            if (!isset($_SESSION['loggedIn']))
            {
                ?>
                            <div class="comments-profile">
                <a href="/authorize.php">
                <div class="comments-profile__login">
                    Войти
                </div>
                    </a>
            </div>
            </div>
            <?php
            }
            else
            {
                ?>
                </div>
                <form method="POST"><div class="comments__form">
                    <div class="comments__photo-wrapper">
                        <div class="comments__photo-link">
                            <?php 
                            $currentUserName = $_SESSION['username'];
                            $userPhoto = mysqli_fetch_assoc(mysqli_query($connect,
                            "SELECT * FROM `Клиент` WHERE `Никнейм` = '$currentUserName' LIMIT 1"));
                            ?>
                            <img class="comments__photo" src="<?php echo "../" . $userPhoto['Аватар'] ?>"> 
                        </div>
                    </div>
                    <div class="comments__text-field">
                        <p> <?php echo $_SESSION['username'] ?> </p>
                        <textarea name="reviewText" required maxlength = "400" class="comments__textarea" placeholder="Напишите ваш отзыв" style="height: 97px;"></textarea>
                    <div class="comments__btn-wrapper">
                        <button type="submit" name="publishing" class="comments__btn">
                            <span class="comments__btn-text">Опубликовать</span>
                        </button></div></div></div></form>
                        <?php
            }
            ?>
                <?php 
                if (mysqli_num_rows($currentProductReviews) != 0)
                {
                   ?> <div>
                    <ul class="comments__list">
                        <?php
                while($row = mysqli_fetch_assoc($currentProductReviews))
                {
                ?>
                        <li class="comments__item">
                            <div class="comments__container" style="max-width: 75%; min-width:75%">
                                <div class="comments__item-comment">
                                    <div class="comments__photo-wrapper">
                                    <?php 
                            $currentUserName = $row['Никнейм'];
                            $userPhoto = mysqli_fetch_assoc(mysqli_query($connect,
                            "SELECT * FROM `Клиент` WHERE `Никнейм` = '$currentUserName' LIMIT 1"));
                            ?>
                            <img class="comments__photo" src="<?php echo "../" . $userPhoto['Аватар'] ?>"> 
                                    </div>
                                    <div class="comments__item-content">
                                        <div class="comments__comment-header">
                                            <div class="comments__comment-info">
                                                <div class="comments__comment-name">
                                                    <div class="comments__profile-link" style="display: flex">
                                                        <?php
                                                        $nicknameUser = $row['Никнейм'];
                                                        ?>
                                                        <b style="margin: auto">
                                                            <?php echo $nicknameUser?>
                                                        </b>
                                                        <?php
                                                         if (($row['Никнейм'] == $_SESSION["username"]) && $_SESSION["loggedIn"])
                                                         {
                                                            ?>
                                                            <form method="POST" style="align-self:center" action="../edit-review.php">
                                                            <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                                            <input type="hidden" name="reviewedit" value="<?php echo $row['Id отзыва']; ?>">
                                                            <div>
                                                    <button type="submit" class="comments__btn change__btn ">
                                                        <span class="comments__btn-text">Изменить</span>
                                                    </button></div>
                                            </form> 
                                            <?php
                                                         }
                                                        $checkReality = mysqli_query($connect,
                                                        "SELECT * FROM `Товар-заказ` WHERE `Код заказа` = ANY (SELECT `Код заказа`
                                                         FROM `Заказ` WHERE `Никнейм` = '$nicknameUser') 
                                                        AND `Код товара` = '$productId' LIMIT 1");
                                                        if (mysqli_num_rows($checkReality) !=0)
                                                        {
                                                            echo "<p><i>&nbspРеальный покупатель</i>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="comments__comment-date">
                                                    <?php echo $row['Дата и время']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comments__comment">
                                            <span>
                                                <span style="overflow-wrap: anywhere;display: inline-grid;">
                                                    <?php echo $row['Текст отзыва']; ?>
                                                </span>
                                            </span>
                                         </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (($row['Никнейм'] == $_SESSION["username"]) && $_SESSION["loggedIn"])
                                {
                                    ?>
                                <form method="POST" action="../delete-comment.php">
                                <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="reviewCode" value="<?php echo $row['Id отзыва']; ?>">
                                <div>
                        <button type="submit" class="comments__btn">
                            <span class="comments__btn-text">Удалить</span>
                        </button>
                    </div>
                </form>
                <div>
                                </div>    
                </li>
                <?php
                                } 
                }
                ?>
                                                </div>
            </ul>          
                <?php
            }
                ?>
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
</body>
</html>