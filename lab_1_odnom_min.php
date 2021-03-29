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
    <title>Лабораторная работа 1 Одномерная минимизация- Веб-портал по лабораторным работам МАИ</title>
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
        		<div type="submit" onclick="document.location='/index.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/home2.svg"></img> Рабочий стол </div></li>

            <li class="theory">
            <div type="submit" onclick="document.location='/courses.php'" class="current"><img class="current-image" xmlns="http://www.w3.org/2000/svg" src="/img/theory2.svg"></img> Теория</div></li>

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
            <div type="submit" onclick="document.location='/index.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/home2.svg"></img> Рабочий стол </div></li>

            <li class="theory">
            <div type="submit" onclick="document.location='/courses.php'" class="current"><img class="current-image" xmlns="http://www.w3.org/2000/svg" src="/img/theory2.svg"></img> Теория</div></li>

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
        
        
        <form autocomplete="off" class="search" action="/labs.php">
          <div class="autocomplete">
            
          <input id="myInput" type="text" name="myCourses"  placeholder="Поиск курса...">
          <input type="image" id="myBtn" class="search-button" xmlns="http://www.w3.org/2000/svg" src="/img/search.svg"> </div>
            <input type="hidden" name="course_id" id="courseid">
        </form>
          <script  defer src="js/searchbar.js"></script>
          <script>
              <?php
              if ($user['role_id'] == 1) {
                  $myArr = dbtoarray($pdo);
              }else{
                  $myArr = getAssignedCourses($pdo, $user['user_id']);
              }
              $names_arr = array();
              $ids_arr = array();
              for($i=0; $i < count($myArr); $i++){
                  $names_arr[] = $myArr[$i]["course_name"];
                  $ids_arr[] = $myArr[$i]["course_id"];
              };
              ?>
              var courses = [ <?php
                  echo '"'.implode('","', $names_arr).'"'
                  ?>];
              var courses_id = [<?php
                  echo '"'.implode('","', $ids_arr).'"'
                  ?>];
          </script>
        <p class="desktop-lab">Лабораторная работа №1 “Методы минимизации функций одной переменной”</p>
        <div class="lab_body">
          <iframe src="/pdfs/Lab_1_odnom_min.pdf" ></iframe>
          <p class="lab_text"> Скачать программы, указанные в тексте лабораторной работы, можно по ссылке  </p><a href="https://github.com/307-labs/lab1_odnom">https://github.com/307-labs/lab1_odnom</a>
          <p><button type="submit" onclick="document.location='/test_Lab_1_odnom_min.php'" class="goto-test">Пройти тест для самопроверки</button> </p>

    </div>
    </div>


      <div class="info-menu">
        <div class="info-contents">
        <div class="avatar"><img class="avatar-img" src="/img/prof_pic.png"></img></div>
        <p class="fio-name"> 
            <?=$user["fio"]; ?></p>
         <?php
            if ($user['role_id'] == 1 || $user['role_id'] == 3){
            ?><p class="caption"> Группа </p>
        <p class="caption-group"><?=$user["group_name"]; ?> </p>
        <p class="caption"> Мои курсы </p>
        <div class="my-courses">
          <ul class="course-list">
            <?php
            if ($user['role_id'] == 3){
                for ($si=0; $si < count($myArr) && $si < 4; $si++){
                $value = $myArr[$si];
             ?>
            <li class="choose-course">
              <div type="button" onclick="document.location='/course.php?course_id=<?=$value['course_id']; ?>'" class="course-button"><p class="button-text"><?=$value['course_name']; ?> </p><img class="course-image" xmlns="http://www.w3.org/2000/svg" src="/img/arrow.svg"></img> </div>
            </li>
            <?php
          }}
              ?>
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