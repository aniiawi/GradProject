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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1">
    <title>Обратная связь - Веб-портал по лабораторным работам МАИ</title>
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
  	<main class="d-flex">
  		<nav class="menu-width-100" id="menu">
          <ul class="menu_list">
            <li class="homepage">
        		<div type="submit" onclick="document.location='/index.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/home2.svg"></img> Рабочий стол </div></li>

            <li class="theory">
        		<div type="submit" onclick="document.location='/courses.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/theory.svg"></img> Теория</div></li>

            <li class="tests">
        		<div type="submit" onclick="document.location='/tests.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/tests.svg"></img> Тесты</div></li>

            <li class="feedback">
        		<div type="submit" onclick="document.location='/feedback.php'" class="current"><img class="current-image" xmlns="http://www.w3.org/2000/svg" src="/img/feedback2.svg"></img> Обратная связь</div></li>
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
            <div type="submit" onclick="document.location='/courses.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/theory.svg"></img> Теория</div></li>

            <li class="tests">
            <div type="submit" onclick="document.location='/tests.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/tests.svg"></img> Тесты</div></li>

            <li class="feedback">
            <div type="submit" onclick="document.location='/feedback.php'" class="current"><img class="current-image" xmlns="http://www.w3.org/2000/svg" src="/img/feedback2.svg"></img> Обратная связь</div></li>
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
        <p class="desktop">Обратная связь</p>
        <div class="cards">
          <form name="form" action="mail.php" method="post" id="form_message">
            <div class="upper-container">
              <input type="text" class="user-input" placeholder="Имя" name="fio-name" required>
              <input type="text" class="user-input" placeholder="Группа" name="group-name" required>
              <input type="text" class="user-input" placeholder="E-mail" name="email" required>
              <select class="user-input" name="subjects" id="dropdown">
                  <option class="selection-basic">Выберите тему вопроса...</option>
                  <option class="selection" value="Вопрос по выполнению работы">Вопрос по выполнению работы</option>
                  <option class="selection" value="Неточность в содержании">Неточность в содержании</option>
                  <option class="selection" value="Огранизационные вопросы">Организационные вопросы</option>
                  <option class="selection" value="Другое">Другое</option>
              </select></div>

              <p class="upper-container"><textarea type="text" class="user-input-msg" placeholder="Ваше сообщение" name="user-message" cols="num" rows="num" required></textarea></p>
                    
            <p> <input name="submit" type="submit" value="Отправить" class="send-button"></p>
  </form>
        
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
                foreach(getAssignedCourses($pdo, $user['user_id']) as $value){
             ?>
            <li class="choose-course">
              <div type="button" onclick="document.location='/labs.php?course_id=<?=$value['course_id']; ?>'" class="course-button"><p class="button-text"><?=$value['course_name']; ?> </p><img class="course-image" xmlns="http://www.w3.org/2000/svg" src="/img/arrow.svg"></img> </div>
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