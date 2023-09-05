<?php
require_once ("connect.php");
session_start();
ob_start();

if(!isset($_SESSION['username']))
    {
        header("Location: index.php");
    }

$messageSuccess = $_SESSION['successmsg'];
$messageError = $_SESSION['errormsg'];
unset($_SESSION['errormsg']);
unset($_SESSION['successmsg']);
if ($_SESSION['isVerified'])
{
$currentNickname =$_SESSION['username'];
$currentUser=mysqli_fetch_assoc(
    mysqli_query($connect, "SELECT * FROM `Клиент`
WHERE `Никнейм` = '$currentNickname'"));

if (isset($_POST['changePassword'])) {
    $currentUserPassword =$currentUser['Хэш-пароль'];
    $oldhashPass=$currentUserPassword;
    $newPassword = $_POST['textPassword'];
    if (password_verify($newPassword, $currentUserPassword))
    {
        $error="Нельзя изменить пароль на такой же!";
        $_SESSION['errormsg'] = $error;
    }
    else
    {
    $password_hash = password_hash($newPassword, PASSWORD_BCRYPT);
    $hashPass=$password_hash;
    $query = mysqli_query($connect, "UPDATE `Клиент` SET 
    `Хэш-пароль` = '$password_hash' WHERE `Никнейм` = '$currentNickname'");
    $success='Пароль был успешно изменен';
    $_SESSION['successmsg'] = $success;
    }
    header("Location: change-password.php");
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>Изменить пароль</title>
</head>
<body>
    <?php include('header.php'); ?>
    <main>
        <div class ="profile-reviews product-reviews product-block" style = "min-height: auto">
        <div style="padding: 10px; border-bottom: 1px solid grey;">
        <form method="POST" style="display: flex; justify-content: space-between">
        <label>Новый пароль
        <input name="textPassword" type="password" class="comment-text" type="text" placeholder="Введите новый пароль от 8 до 32 символов" 
        minlength = "8" maxlength = "32" required style="width: 300px">
        </label>
         <div>
            <button name="changePassword" type="submit" class="comments__btn">
                 <span class="comments__btn-text">Сохранить</span>
                        </button></div>
        </form>
        <?php if ($messageSuccess!="")
        {
            ?>
        <p style="color: green"><?php
        echo "$messageSuccess!";
        ?> 
        </p>
        <?php
         }
         ?>
        <p style="color:red"><?php 
        echo "$messageError" 
        ?> 
        </p>
</div>
</div>
    </main>
    <?php include('footer.php'); ?>
    <script src="main.js"></script>  
</body>
</html>
<?php 
}
else
{
    unset($_SESSION['isVerified']);
    unset($_SESSION['passwordChngd']);
    ?>
    <div style="margin-top: 250px">
    <h1 style="text-align: center">
        Страница устарела <br>
        Вернитесь на главную
    </h1>
    <div class="main__logo" style="text-align: center">
        <a class="main__logo-link" href="/index.php">
        <img src="/IMG/gamestoreClear.png" width="400">
        </a>
    </div>
</div>
    <?php
}
?>