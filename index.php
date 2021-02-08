<?php
require_once "additional/auth.php";
$pdo = pdoconnect();
$user = simplecoockieauth($pdo, true);
if ($user === false) {
    f_exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1">
    <title>Рабочий стол - Веб-портал по лабораторным работам МАИ</title>
    <link rel="shortcut icon" href="https://dev.mai.ru/generic/images/favicon/1.6/favicon-2015.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/index.css">
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
  	<main class="d-flex">
  		<nav class="menu-width-100" id="menu">
          <ul class="menu_list">
            <li class="homepage">
        		<div type="submit" onclick="document.location='/index.php'" class="current"><img class="current-image" xmlns="http://www.w3.org/2000/svg" src="/img/home.svg"></img> <p>Рабочий стол </p></div></li>

            <li class="theory">
        		<div type="submit" onclick="document.location='/theory.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/theory.svg"></img> Теория</div></li>

            <li class="tests">
        		<div type="submit" onclick="document.location='/tests.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/tests.svg"></img> Тесты</div></li>

            <li class="feedback">
        		<div type="submit" onclick="document.location='/feedback.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/feedback.svg"></img> Обратная связь</div></li>
        	<?php
            if ($user['role_id'] < 3){
            ?>  <li class="add_llab">
                <div type="submit" onclick="document.location='/addlab.php'" class="add_lab"><img class="addlab-image" xmlns="http://www.w3.org/2000/svg" src="/img/addlab.svg"></img> Генератор кодов</div></li>
            <?php
            }
            ?>
           
             
          </ul>
            
			         <input type="button" onclick="document.location='/exit.php'" value="Выйти" class="logout-button">
      </nav>

<div class="menu-mobile">
        <script  src="js/menumob.js"></script>
        <a  class="icon" onclick="barFunction()">
              <div class="burger"></div>
          </a>
         <nav id="navLinks">
          <ul class="menu_list-mobile">
           
            <li class="homepage">
            <div type="submit" onclick="document.location='/index.php'" class="current"><img class="current-image" xmlns="http://www.w3.org/2000/svg" src="/img/home.svg"></img> <p>Рабочий стол </p></div></li>

            <li class="theory">
            <div type="submit" onclick="document.location='/theory.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/theory.svg"></img> Теория</div></li>

            <li class="tests">
            <div type="submit" onclick="document.location='/tests.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/tests.svg"></img> Тесты</div></li>

            <li class="feedback">
            <div type="submit" onclick="document.location='/feedback.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/feedback.svg"></img> Обратная связь</div></li>
          <?php
            if ($user['role_id'] < 3){
            ?>  <li class="add_llab">
                <div type="submit" onclick="document.location='/addlab.php'" class="add_lab"><img class="addlab-image" xmlns="http://www.w3.org/2000/svg" src="/img/addlab.svg"></img> Генератор кодов</div></li>
            <?php
            }
            ?>
             
            <input type="button" onclick="document.location='/exit.php'" value="Выйти" class="logout-button"></nav>

          </ul>
            
               


          
          

      </div>

      <div class="working-area">
        <form autocomplete="off" class="search"> 
          <div class="autocomplete">
          <input id="myInput" type="text" name="myCourses"  placeholder="Поиск по теме...">
          <input type="image" class="search-button" xmlns="http://www.w3.org/2000/svg" src="/img/search.svg"> </div>
        </form>
        <p class="desktop">Рабочий стол</p>
        <p class="desktop-caption"> Мои лабораторные работы </p>
        <div class="cards">
        <li class="card">
          <p class="course-description"> Технический контроль и диагностика систем ЛА - Лабораторная работа №4 “Построение программы поиска неисправностей методом динамического программирования”</p>
          <div type="button" onclick="document.location='/course.php'" class="course-goto"><p>Перейти</p></div>
      </li>
     <li class="card">
          <p class="course-description"> Технический контроль и диагностика систем ЛА - Лабораторная работа №4 “Построение программы поиска неисправностей методом динамического программирования”</p>
          <div type="button" onclick="document.location='/course.php'" class="course-goto"><p>Перейти</p></div>
      </li>
      <li class="card">
          <p class="course-description"> Технический контроль и диагностика систем ЛА - Лабораторная работа №4 “Построение программы поиска неисправностей методом динамического программирования”</p>
          <div type="button" onclick="document.location='/course.php'" class="course-goto"><p>Перейти</p></div>
      </li>
    </div>
    </div>


      <div class="info-menu">
        <div class="info-contents">
        <div class="avatar"><img class="avatar-img" src="/img/prof_pic.png"></img></div>
        <p class="fio-name"> 
            <?=$user["fio"]; ?></p>
         <?php
            if ($user['role_id'] = 1 || $user['role_id'] = 3){
            ?><p class="caption"> Группа </p>
        <p class="caption-group"><?=$user["group_name"]; ?> </p>
        <p class="caption"> Мои курсы </p>
        <div class="my-courses">
          <ul class="course-list">
            <li class="choose-course">
              <div type="button" onclick="document.location='/course.php'" class="course-button"><p class="button-text">Методы оптимизации информационных систем </p><img class="course-image" xmlns="http://www.w3.org/2000/svg" src="/img/arrow.svg"></img> </div>
            </li>
            <li class="choose-course">
              <div type="button" onclick="document.location='/course.php'" class="course-button"><p class="button-text">Надежность информационных систем и защита информации </p><img class="course-image" xmlns="http://www.w3.org/2000/svg" src="/img/arrow.svg"></img> </div></li>
          </ul>
        </div>
        <?php
            }
            ?>
      </div>
      </div>

    </main> 
  </body>
</html>