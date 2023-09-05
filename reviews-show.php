<?php
require_once ("connect.php");
session_start();
ob_start();

if(!isset($_SESSION['username']))
    {
        header("Location: index.php");
    }

$currentNickname =$_SESSION['username'];

$usersReviews = mysqli_query($connect, "SELECT * FROM `Отзыв`
WHERE `Никнейм` = '$currentNickname' ORDER BY `Дата и время` DESC");

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>Мои отзывы</title>
</head>

<body>
    <?php include('header.php'); ?>
    <main>
    <div class="profile-reviews product-reviews product-block">
            <div class="comments__header">
            <div class="comments__title">
                Ваши отзывы
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
                if (mysqli_num_rows($usersReviews) != 0)
                {
                    ?> <div>
                    <ul class="comments__list">
                        <?php
                while($row = mysqli_fetch_assoc($usersReviews))
                {
                ?>
                        <li class="comments__item">
                            <div class="comments__container" style="max-width: 75%; min-width:75%">
                                <div class="comments__item-comment">
                                    <div class="comments__photo-wrapper">
                                    <?php 
                            $currentUserName = $_SESSION['username'];
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
                                                                    <form method="POST" style="align-self:center" action="edit-review.php">
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
                                                                                                       <br>
                                                    <br>
                                                    <?php 
                                                    $gameId = $row['Код товара'];
                                                    $game=mysqli_fetch_assoc(
                                                        mysqli_query($connect, "SELECT * FROM `Товар`
                                                    WHERE `Код товара` = $gameId"));
                                                    ?>
                                                    <?php echo "Отзыв к игре " ?>
                                                    <a href ="/games/product.php?id=<?php echo $game['Код товара']?>">
                                                    <?php echo $game['Наименование товара'] ?>
                                                    </a>
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
            else
            {
                ?>
                <p>Вы пока ещё не оставляли отзывов</p>
                <?php
            }
                ?>
            </div>

    </main>
    <?php include('footer.php'); ?>
</body>
</html>