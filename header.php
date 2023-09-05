<?php
require_once "connect.php";
session_start();
?>
<header class="main-header">
        <div class="main-header__inner">
            <a href="index.php" class="gamestore-logo">
                <img src="IMG/gamestore.png" width="150">
            </a>
            <button class="main-header__btn main-header__menu" onclick='showMenu()'>
                <a href="#" class="main-header__more">
                    <img src="IMG/more.svg" width="30" >
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
                <img src="IMG/cart.png" width="25"></img>
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
                <a href="/cart.php" class="main-header__btn main-header__btn--right">
                <img src="IMG/cart.png" width="25"></img>
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
            <a href="/authorize.php" class="registration main-header__btn main-header__btn--right">
            <img src="IMG/private.png" width="25">
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
                <img src="IMG/private.png" width="25"></a>
                        <ul class="catalog__list">
                            <li>
                                <a href="/profile.php" class="catalog__item"><i><?php echo $_SESSION['username']?></i></a>
                            </li>
                            <li>
                                <a href="/logout.php" class="catalog__item"><i>Выйти</i></a>
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