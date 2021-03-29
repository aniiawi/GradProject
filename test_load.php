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

$assigned = false;

foreach(getAssignedLabs($pdo, $user['user_id']) as $lab){
    if ($lab['lab_id'] == $_GET['lab_id']){
        $assigned = true;
        break;
    }
}

if (!$assigned){
    header("Location: /index.php");
    exit();
}

$test= getTestByLabId($pdo, $_GET['lab_id']);
$jsonObj = json_decode($test['test_content'], true);
if (!isset($_GET['check'])){
    foreach ($jsonObj as &$value){
        unset($value['correctAnswer']);
    }
    unset($value);

    header('Content-type: application/json');
    echo json_encode($jsonObj);
    exit();
}


