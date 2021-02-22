<meta http-equiv='refresh' content='3; url=http://an314muc.beget.tech/feedback.php'>
<meta charset="UTF-8" >
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