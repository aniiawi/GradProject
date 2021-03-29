<?php
require_once "additional/auth.php";
$pdo = pdoconnect();
$user = simplecoockieauth($pdo, true);
if ($user === false) {
    f_exit();
}


if (!isset($_GET['lab_id']) || empty($_GET['lab_id'])){
    header("Location: /index.php");
    exit();
}
$lab_name = "";
$assigned = false;

foreach(getAssignedLabs($pdo, $user['user_id']) as $lab){
    if ($lab['lab_id'] == $_GET['lab_id']){
        $assigned = true;
        $lab_name = $lab['lab_name'];
        break;
    }
}

if (!$assigned){
    header("Location: /index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1">
    <title>Тест для самопроверки - Веб-портал по лабораторным работам МАИ</title>
    <link rel="shortcut icon" href="https://dev.mai.ru/generic/images/favicon/1.6/favicon-2015.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        var test_content = <?=$_GET['lab_id']; ?>;
    </script>
    <script defer src="/js/ajax_quest.js"></script>
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
            <div type="submit" onclick="document.location='/tests.php'" class="current"><img class="current-image" xmlns="http://www.w3.org/2000/svg" src="/img/test2.svg"></img> Тесты</div></li>

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
            <div type="submit" onclick="document.location='/courses.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/theory.svg"></img> Теория</div></li>

            <li class="tests">
            <div type="submit" onclick="document.location='/tests.php'" class="current"><img class="current-image" xmlns="http://www.w3.org/2000/svg" src="/img/test2.svg"></img> Тесты</div></li>

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
        <p id="labname" class="desktop-lab"><?=$lab_name; ?></p>
          <div id="container">
           <div id="content" class="lab_text_test">

            <p class="take-quiz"> Пройти тест для самопроверки</p>

            <div id="alert">Something went wrong</div>

            <div id="quiz">
                <form id="myForm" action="" method="post">
                    <div id="form-question">
                        No questions to show
                    </div>
                    <div id="form-answers">
                        <input type="radio" class="form-radio" name="answer1" id="Name" value="Laurence"> Laurence
                    </div>
                </form>
            </div>

            <div  id="nextButton" class="goto-test-mod">Далее</div>
            <div  id="nextButton2" class="goto-test-mod" style="display: none;">Далее</div>
        </div>
      </div>

    </div>


      <div class="info-menu">
        <div class="info-contents">
        <div class="avatar"><img class="avatar-img" src="/img/prof_pic.png"></div>
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