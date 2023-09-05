<?php
require_once "connect.php";

$reviewId = $_POST["reviewCode"];
$redirect = $_POST["redirect"];

mysqli_query($connect, "DELETE FROM `Отзыв` WHERE `Id отзыва` = '$reviewId'");
header("Location: $redirect");
?>