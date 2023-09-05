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


if (isset($_POST['changeName'])) {
    $currentUserName =$currentUser['Никнейм'];
    $newName = $_POST['textName'];
    if ($currentUserName == $newName)
    {
        $error="Нельзя изменить ник на такой же!";
        $_SESSION['errormsg'] = $error;
    }
    else
    {
    $query = mysqli_query($connect, "UPDATE `Клиент` SET 
    `Никнейм` = '$newName' WHERE `Никнейм` = '$currentUserName'");
        if ($query) {
            $_SESSION['username'] = $newName;
            $success='Имя было успешно изменено на';
            $_SESSION['successmsg'] = $success;
        }
        else {
            $error='Этот никнейм уже занят!';
            $_SESSION['errormsg'] = $error;
        }
    }
    header("Location: change-username.php");
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>Изменить никнейм</title>
</head>

<body>
    <?php include('header.php'); ?>
    <main>
        <div class ="profile-reviews product-reviews product-block" style = "min-height: auto">
        <div style="padding: 10px; border-bottom: 1px solid grey;">
        <form method="POST" style="display: flex; justify-content: space-between">
        <label>Новое имя
        <input name="textName" class="comment-text" type="text" value = "<?php echo $_SESSION['username']?>" 
        minlength = "4" maxlength = "16" required>
        </label>
         <div>
            <button name="changeName" type="submit" class="comments__btn">
                 <span class="comments__btn-text">Сохранить</span>
                        </button></div>
        </form>
        <?php if ($messageSuccess!="")
        {
            ?>
        <p style="color: green"><?php
        echo "$messageSuccess " . $_SESSION['username'] ?> 
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