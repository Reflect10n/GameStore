<?php
require_once ("connect.php");
session_start();
ob_start();

$currentNickname =$_SESSION['username'];
$currentUser=mysqli_fetch_assoc(
    mysqli_query($connect, "SELECT * FROM `Клиент`
WHERE `Никнейм` = '$currentNickname'"));

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
    <script src="main.js"></script>
    <title>GameStore — Личный кабинет</title>
</head>

<body>
    
    <?php include('header.php'); ?>
    <main>
        <div class ="profile-reviews product-reviews product-block" style = "min-height: auto">
        <div style="padding: 10px; border-bottom: 1px solid grey; display: flex; justify-content: space-between">
        <label>Имя пользователя: <?php echo $_SESSION['username']?></label>
        <form method="POST" action="change-username.php">
                                <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="profusername" value="<?php echo $currentUser['Никнейм']; ?>">
                                <div>
                        <button type="submit" class="comments__btn">
                            <span class="comments__btn-text">Изменить</span>
                        </button></div>
                </form>
</div>
<div style="padding: 10px; border-bottom: 1px solid grey; display: flex; justify-content: space-between">
        <label>Электронная почта: <?php echo $currentUser['Электронная почта']?></label>
        <form method="POST" action="change-email.php">
                                <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="profemail" value="<?php echo $currentUser['Электронная почта']; ?>">
                                <div>
                        <button type="submit" class="comments__btn">
                            <span class="comments__btn-text">Изменить</span>
                        </button></div>
                </form>
        </div>
        <div style="padding: 10px; border-bottom: 1px solid grey; display: flex; justify-content: space-between">
        <label >Пароль: ****************</label>
        <form method="POST" action="verify-password.php">
                                <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <div>
                        <button type="submit" class="comments__btn">
                            <span class="comments__btn-text">Изменить</span>
                        </button></div>
                </form>
        </div>
        <div style="padding: 10px; border-bottom: 1px solid grey">
        <a href = "reviews-show.php">
        <label>Мои Отзывы</label>
</a>
</div>
<div style="padding: 10px; border-bottom: 1px solid grey">
        <a href = "purchases-show.php">
        <label>Мои Покупки</label>
</a>
</div>
</div>
    </main>
    <?php include('footer.php'); ?>
</body>
</html>