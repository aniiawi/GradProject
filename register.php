<?php
require_once "additional/auth.php";
$pdo = pdoconnect();
$aerr = '';
if (!simplecoockieauth($pdo)) {
    $aerr = register($pdo);
    if ($aerr === true){
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
    <title>Регистрация - Веб-портал по лабораторным работам МАИ</title>
    <link rel="shortcut icon" href="https://dev.mai.ru/generic/images/favicon/1.6/favicon-2015.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/login.css">
  </head>
  <body>
  <style>
      .un-input{
          margin-top: 5px;
          margin-bottom: 5px;
      }
  </style>
  	<main class="d-flex">
  		<div class="auth">
  				<form class="authbody" id="form-login" action method="post" name="f">
        				<img class="f-image" xmlns="http://www.w3.org/2000/svg" src="/img/ps_lab.svg">
        				</img>
        			<h1 class="text">Электронное пособие по лабораторным работам</h1>
               <input type="text" class="un-input" placeholder="КОД РЕГИСТРАЦИИ" name="reg-id">
                  <input type="text" class="un-input" placeholder="ИМЯ ПОЛЬЗОВАТЕЛЯ" name="username" required>
							<input type="password" class="un-input" id="password-input" placeholder="ПАРОЛЬ" name="password">
                        <input type="password" class="un-input" id="password-input" placeholder="ПОВТОРИТЕ ПАРОЛЬ" name="password2">
                    <input type="text" class="un-input" id="fio-input" placeholder="ФИО" name="fio-input">
                    <?php
                    if ($aerr!== true && $aerr!==NULL){
                        ?><p class="error_color"><?=$aerr['err']; ?> </p>
                        <?php
                    }
                    ?>
						<input name="submit" type="submit" value="Зарегистрироваться" class="un-input button">
						 <a class="registration" href="/login.php"> Войти </a>
        </form>
      </div>

      <div class="picture"></div>
    </main>  
  </body>
</html>