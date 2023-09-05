<?php
require_once ("connect.php");
session_start();
ob_start();
$reviewCode = $_POST['reviewedit'];
$reviewArray = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `Отзыв` WHERE `Id отзыва` = '$reviewCode' LIMIT 1"));
$messageSuccess = $_SESSION['messageSuccess'];
unset($_SESSION['messageSuccess']);

if(!isset($_SESSION['username']))
    {
        header("Location: index.php");
    }

if (isset($_POST['editReview'])) {
    $newReviewText = $_POST['reviewText'];
    $reviewId = $_POST['reviewId'];
    $datetime = new DateTime();
    $actualDate = $datetime->format('Y-m-d H:i:s');
    $query = mysqli_query($connect, "UPDATE `Отзыв` SET 
    `Текст отзыва` = '$newReviewText', `Дата и время` = '$actualDate' WHERE `Id отзыва` = $reviewId");
    $_SESSION['messageSuccess'] = "Отзыв успешно изменен";
    header("Location: edit-review.php");
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Изменить отзыв</title>
</head>
<body>
    <?php include('header.php'); ?>
    <main>
        <div class ="profile-reviews product-reviews product-block" style = "min-height: auto">
        <div style="padding: 10px;">
        <form method="POST" style="display: flex; justify-content: space-between">
        <label>Изменение отзыва
        </label>
        <textarea name="reviewText" required maxlength = "400" class="comments__textarea"style="height: 97px;"><?php echo $reviewArray['Текст отзыва'];?></textarea>
        <input type="hidden" name="reviewId" value="<?php echo $reviewArray['Id отзыва']; ?>">
        </div>
        <div>
            <button name="editReview" 
            style=" float: right; margin-right: 10px;"type="submit" class="comments__btn">
                 <span class="comments__btn-text">Изменить</span>
                        </button></div>
        </form>
        <?php if ($messageSuccess!="")
        {
            ?>
        <p style="color: green"><?php
        echo "$messageSuccess "?> 
        <?php 
        }?>
        </p>
</div>
    </main>
    <?php include('footer.php'); ?>
    <script src="main.js"></script>  
</body>
</html>