<?php
require_once ("connect.php");
session_start();
ob_start();

$currentNickname =$_SESSION['username'];

if(!isset($_SESSION['username']))
    {
        header("Location: index.php");
    }

$usersPurchases = mysqli_query($connect, "SELECT * FROM `Заказ`
WHERE `Никнейм` = '$currentNickname' ORDER BY `Код заказа` DESC");

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>Мои заказы</title>
</head>

<body>
    <?php include('header.php'); ?>
    <main>
    <div class="profile-reviews product-reviews product-block">
            <div class="comments__header">
            <div class="comments__title">
                Ваши заказы
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
                        <?php
            }
            ?>
                <?php 
                if (mysqli_num_rows($usersPurchases) != 0)
                {
                    ?>
                <div>
                    <ul class="comments__list">
                    <?php 
                    while($row = mysqli_fetch_assoc($usersPurchases))
                    {
                    ?>
                        <li class="comments__item" style="border-bottom: none">
                        <form method="POST" action="view-purchases.php" style="min-width:800px; max-width:800px">
                                <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="orderCode" value="<?php echo $row['Код заказа']; ?>">
                        <button type="submit" class="btn-view-purchase" style="width: 100%;
                        border: none; cursor: pointer; margin-bottom: 20px">
                            <div class="comments__container">
                                <div class="comments__item-comment">
                                    <div class="comments__photo-wrapper" style="margin-top:-8px">
                                        <img class="comments__photo" src="/IMG/items/cartOrder.png" >
                                    </div>
                                    <div class="comments__item-content">
                                        <div class="comments__comment-header">
                                            <div class="comments__comment-info">
                                                <div class="comments__comment-name">
                                                    <div class="comments__profile-link">
                                                        <?php echo "Заказ № " . $row['Код заказа']; ?>
                                                    </div>
                                                </div>
                                                <div class="comments__comment-date">
                                                    <?php echo $row['Дата и время']; ?>
                                                </div>
                                                <div>
                                                    <p><?php
                                                    $paymentType = $row['Тип оплаты'];
                                                     echo "Способ оплаты: " . $paymentType ?>
                                                     </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </li>
                                <?php 
                }
                ?>
            </ul>          
                <?php
            }
                ?>
            </div>

    </main>
    <?php include('footer.php'); ?>
    <script src="main.js"></script>  
</body>
</html>