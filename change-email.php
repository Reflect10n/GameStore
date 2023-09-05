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
$currentNickname =$_SESSION['username'];
$currentUser=mysqli_fetch_assoc(
    mysqli_query($connect, "SELECT * FROM `Клиент`
WHERE `Никнейм` = '$currentNickname'"));

if (isset($_POST['changeEmail'])) {
    $currentUserEmail =$currentUser['Электронная почта'];
    $newEmail = $_POST['textEmail'];
    if ($currentUserEmail == $newEmail)
    {
        $error="Нельзя изменить почту на такую же!";
        $_SESSION['errormsg'] = $error;
    }
    else
    {
        $query = mysqli_query($connect, 
        "SELECT * FROM `Клиент` WHERE `Электронная почта`='$newEmail'");
        if (mysqli_num_rows($query) != 0) {
            $error='Этот адрес уже зарегистрирован!';
            $_SESSION['errormsg'] = $error;
        }
        else
        {
    $query = mysqli_query($connect, "UPDATE `Клиент` SET 
    `Электронная почта` = '$newEmail' WHERE `Никнейм` = '$currentNickname'");
        if ($query) {

            $success='Почта была успешна изменена на';
            $_SESSION['successmsg'] = $success;
        }
        else {
            $error='Эта почта уже занята!';
            $_SESSION['errormsg'] = $error;
        }
    }
}
    header("Location: change-email.php");
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>Изменить почту</title>
</head>

<body>
    <?php include('header.php'); ?>
    <main>
        <div class ="profile-reviews product-reviews product-block" style = "min-height: auto">
        <div style="padding: 10px; border-bottom: 1px solid grey;">
        <form method="POST" style="display: flex; justify-content: space-between">
        <label>Новая почта
        <input name="textEmail"  type="email" class="comment-text" type="text" value = "<?php echo $currentUser['Электронная почта']?>" 
        maxlength="200" required>
        </label>
         <div>
            <button name="changeEmail" type="submit" class="comments__btn">
                 <span class="comments__btn-text">Сохранить</span>
                        </button></div>
        </form>
        <?php if ($messageSuccess!="")
        {
            ?>
        <p style="color: green"><?php
        echo "$messageSuccess " . $currentUser['Электронная почта'] ?> 
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