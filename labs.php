<?php
require_once "additional/auth.php";
$pdo = pdoconnect();
$user = simplecoockieauth($pdo, true);
if ($user === false) {
    f_exit();
}

if (isset($_GET['lab_id']) && !empty($_GET['lab_id'])){
    $redirect = "Location: /index.php";
    foreach(getAssignedLabs($pdo, $user['user_id']) as $lab){
        if ($lab['lab_id'] == $_GET['lab_id']){
            $redirect = "Location: ".$lab['lab_page']."?lab_id=".$_GET['lab_id'];
            break;
        }
    }
    header($redirect);
    exit();
}
if (!isset($_GET['course_id']) || empty($_GET['course_id'])){
    header("Location: /index.php");
    exit();
}

if ($user['role_id'] == 1) {
    $myArr = dbtoarray($pdo);
}else{
    $myArr = getAssignedCourses($pdo, $user['user_id']);
}
$course_name = "";
$assigned = false;
for($i=0; $i < count($myArr); $i++){
    if ($myArr[$i]['course_id'] == $_GET['course_id']){
        $assigned = true;
        $course_name = $myArr[$i]["course_name"];
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
    <title>Мои курсы - Веб-портал по лабораторным работам МАИ</title>
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
        <script  src="/js/menumob.js"></script>
        <a  class="icon" onclick="barFunction()">
            <div class="burger"></div>
        </a>
        <nav id="navLinks">
            <ul class="menu_list-mobile">

                <li class="homepage">
                    <div type="submit" onclick="document.location='/index.php'" class="not_current"><img class="not-current-image" xmlns="http://www.w3.org/2000/svg" src="/img/home.svg"></img> <p>Рабочий стол </p></div></li>

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
                <input id="myInput" type="text" name="course_name"  placeholder="Поиск курса...">
                <input type="image" id="myBtn" class="search-button" xmlns="http://www.w3.org/2000/svg" src="/img/search.svg"> </div>
            <input type="hidden" name="course_id" id="courseid">
        </form>
        <script  defer src="/js/searchbar.js"></script>
        <script>
            <?php

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
        <p class="desktop"><?=$course_name; ?></p>
        <div class="cards">

            <?php
            if ($user['role_id'] == 3){
                foreach(getAssignedLabs($pdo, $user['user_id'], 0, $_GET['course_id']) as $value){
                    ?>
                    <li class="card">
                        <p class="course-description"><?=$value["lab_name"]; ?></p>
                        <div type="button" onclick="document.location='/labs.php?lab_id=<?=$value['lab_id']; ?>'" class="course-goto"><p>Перейти</p> </div>
                    </li>
                    <?php
                }}
            ?>

        </div>

    </div>

</main>
</body>
</html>