<?php
require_once "additional/auth.php";
$pdo = pdoconnect();
$aerr = '';
if (!simplecoockieauth($pdo)) {
    $aerr = simpleauthpost($pdo);
    if ($aerr === true) {
        header("Location: /index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1">
    <title>Вход - Веб-портал по лабораторным работам МАИ</title>
    <link rel="shortcut icon" href="https://dev.mai.ru/generic/images/favicon/1.6/favicon-2015.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com"> 
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

  </head>
  <body>
  	<main class="d-flex">
  		<div class="auth">
  				<form class="authbody" id="form-login" action method="post" name="f">
        				<img class="f-image" xmlns="http://www.w3.org/2000/svg" src="/img/ps_lab.svg">
        				</img>
        			<h1 class="text">Электронное пособие по лабораторным работам</h1>

                  <input type="text" class="un-input" placeholder="ИМЯ ПОЛЬЗОВАТЕЛЯ" name="username" required>
							<input type="password" class="un-input" id="password-input" placeholder="ПАРОЛЬ" name="password" required>
                    <?php
                        if ($aerr!== true){
                    ?><p class="error_color"><?=$aerr['err']; ?> </p>
                    <?php
                        }
                    ?>
						<input name="submit" type="submit" value="Войти" class="un-input button">
						 <a class="registration" href="/register.php"> Зарегистрироваться </a>
        </form>
      </div>

      <div class="picture"></div>
    </main> 

  </body>
</html>