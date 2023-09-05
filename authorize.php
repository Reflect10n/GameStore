<?php
    session_start();
    $error="";
    $errorLog="";
    include('config.php');

    if(isset($_SESSION['username']))
    {
        header("Location: index.php");
    }

    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $query = $connection->prepare("SELECT * FROM `Клиент` WHERE `Электронная почта`=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $error='Этот адрес уже зарегистрирован!';
        }
        if ($query->rowCount() == 0) {
            $query = $connection->prepare("INSERT INTO `Клиент`(`Никнейм`,`Электронная почта`,
            `Хэш-пароль`) VALUES (:username,:email,:password_hash)");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
                $new_url = '/index.php';
                setcookie('cart', '', time()-3600);
                header('Location: '.$new_url);
            }
            else {
                $error='Этот никнейм уже занят!';
            }
        }
    }

    if (isset($_POST['login'])) {
        $emailLog = $_POST['emailLog'];
        $password = $_POST['passwordLog'];
        $query = $connection->prepare("SELECT * FROM `Клиент` WHERE `Электронная почта`=:emailLog");
        $query->bindParam("emailLog", $emailLog, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            $error='Неверно указана почта или пароль';
        } else {
            if (password_verify($password, $result['Хэш-пароль'])) {
                $username=$result['Никнейм'];
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
                $new_url = '/index.php';
                setcookie('cart', '', time()-3600);
                header('Location: '.$new_url);
            } else {
                $error=$result['Хэш-пароль'];
                $error='Неверно указана почта или пароль';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/IMG/gamestoreico.png" type="image/x-icon">

    <link rel="stylesheet" href="CSS/style.css">
    
    <title>GameStore — Авторизация</title>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="block-dropdown" style="background-color: rgba(0,0,0,0.2); position: absolute; 
    top: 0; left:0; height: 100%; width: 100%; z-index: 10; display: none;"></div>
    <main>
	<div class="authorize">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form method="POST">
					<label class="label-authorize" for="chk" aria-hidden="true">Регистрация</label>
                    <p class="authorize-error"><?php echo $error?></p>
					<input class="input-authorize" type="text" name="username" placeholder="Никнейм" required minlength = "4" maxlength = "16">
					<input class="input-authorize" type="email" name="email" placeholder="E-Mail" maxlength="200" required>
					<input class="input-authorize"type="password" name="password" placeholder="Пароль" required minlength = "8" maxlength = "32">
					<button type="submit" name="register" class="btn-authorize">Зарегистрироваться</button>
				</form>
			</div>

			<div class="login">
				<form method="POST">
					<label class="label-authorize"  for="chk" aria-hidden="true">Войти</label>
                    <p class="authorize-error"><?php echo $errorLog?></p>
					<input class="input-authorize" type="email" name="emailLog" placeholder="E-Mail" required>
					<input class="input-authorize" type="password" name="passwordLog" placeholder="Пароль" required>
					<button type="submit" name="login" class="btn-authorize">Вход</button>
				</form>
			</div>
	</div>
    </main>
    <?php include('footer.php'); ?>
    <script src="main.js"></script>  
</body>
</html>