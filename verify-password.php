<?php
require_once ("connect.php");
session_start();
ob_start();

$_SESSION['isVerified'] =false;
$messageError = $_SESSION['errormsg'];
unset($_SESSION['errormsg']);
$currentNickname =$_SESSION['username'];
$currentUser=mysqli_fetch_assoc(
    mysqli_query($connect, "SELECT * FROM `Клиент`
WHERE `Никнейм` = '$currentNickname'"));

if(!isset($_SESSION['username']))
    {
        header("Location: index.php");
    }


if (isset($_POST['verifyPassword'])) {
    $currentUserPassword =$currentUser['Хэш-пароль'];
    $actualPassword = $_POST['textPasswordVerify'];
    if (password_verify($actualPassword, $currentUserPassword))
    {
        $_SESSION['isVerified'] = true;
        header("Location: change-password.php");
    }
    else
    {
        $error="Пароли не совпадают!";
        $_SESSION['errormsg'] = $error;
        header("Location: verify-password.php");
    }
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>Подтверждение пароля</title>
</head>
<body>
    <?php include('header.php'); ?>
    <main>
        <div class ="profile-reviews product-reviews product-block" style = "min-height: auto">
        <div style="padding: 10px; border-bottom: 1px solid grey;">
        <form method="POST" style="display: flex; justify-content: space-between">
        <label>Введите пароль:
        <input name="textPasswordVerify" type="password" class="comment-text" type="text" placeholder="Введите ваш текущий пароль" 
        minlength = "8" maxlength = "32" required style="width: 300px">
        <iframe name="myIFR" style="display: none"></iframe>
        </label>
         <div>
            <button name="verifyPassword" type="submit" class="comments__btn">
                 <span class="comments__btn-text">Подтвердить</span>
                        </button></div>
        </form>
        <p style="color:red"><?php 
        echo "$messageError"; 
        ?> 
        </p>
</div>
</div>
    </main>
    <?php include('footer.php'); ?>
</body>
</html>