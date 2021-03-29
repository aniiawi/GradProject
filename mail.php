
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1">
    <title>Обратная связь - Веб-портал по лабораторным работам МАИ</title>
    <meta http-equiv='refresh' content='3; url=http://an314muc.beget.tech/feedback.php'>
<meta charset="UTF-8" >
    <link rel="shortcut icon" href="https://dev.mai.ru/generic/images/favicon/1.6/favicon-2015.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/feedback.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
        li {
          list-style-type: none; /* Убираем маркеры */
        }
        ul {
          margin-left: 0; /* Отступ слева в браузере IE и Opera */
          padding-left: 0; /* Отступ слева в браузере Firefox, Safari, Chrome */
   }
  </style>
  </head>
  <body>
  	<div class="feedback_result">
<?php

	if (isset($_POST['fio-name']) && $_POST['fio-name'] != "")//если существует атрибут NAME и он не пустой то создаем переменную для отправки сообщения
		$name = $_POST['fio-name'];
	else die ("Не заполнено поле \"Имя\"");//если же атрибут пустой или не существует то завершаем выполнение скрипта и выдаем ошибку пользователю.

	if (isset($_POST['group-name']) && $_POST['group-name'] != "") 
		$group = $_POST['group-name'];
	else die ("Не заполнено поле \"Группа\"");

	if (isset($_POST['email']) && $_POST['email'] != "") //тут все точно так же как и в предыдущем случае
		$email = $_POST['email'];
	else die ("Не заполнено поле \"Email\"");

	if (isset($_POST['subjects'])) 
		$sub = $_POST['subjects'];
	else die ("Не заполнено поле \"Тема\"");

	if (isset($_POST['user-message']) && $_POST['user-message'] != "") 
		$body = $_POST['user-message'];
	else die ("Не заполнено поле \"Сообщение\"");
	 


	$address = "AN314@MAIL.RU";//адрес куда будет отсылаться сообщение для администратора
	$mes  = "Имя: $name \n";	//в этих строчках мы заполняем текст сообщения. С помощью оператора .= мы просто дополняем текст в переменную
	$mes .= "Группа: $group \n";
	$mes .= "E-mail: $email \n";
 	$mes .= "Тема: $sub \n";
 	$mes .= "Сообщение: $body"; 
	$send = mail ($address,$sub,$mes,"Content-type:text/plain; charset = UTF-8\r\nFrom:$email");//собственно сам вызов функции отправки сообщения на сервере

	if ($send) //проверяем, отправилось ли сообщение
		echo "Сообщение отправлено успешно! Вы будете автоматически перенаправлены обратно через 3 сек";
	else 
		echo "Ошибка, сообщение не отправлено! Возможно, проблемы на сервере. Вы будете перенаправлены обратно через 3 сек";
		 
?>
</div>
</body>
</html>