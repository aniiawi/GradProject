<?php
require_once "additional/auth.php";
$pdo = pdoconnect();
$user = simplecoockieauth($pdo, true);
if ($user === false) {
    f_exit();
}
$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

if (!isset($data['lab_id']) || empty($data['lab_id']) || !isset($data['answers']) || empty($data['answers']) || gettype($data['answers']) != "array"){
    header("Location: /index.php");
    exit();
}

$assigned = false;
foreach(getAssignedLabs($pdo, $user['user_id']) as $lab){
    if ($lab['lab_id'] == $data['lab_id']){
        $assigned = true;
        break;
    }
}

if (!$assigned){
    header("Location: /index.php");
    exit();
}

$test= getTestByLabId($pdo, $data['lab_id']);
if ($test == false || empty($test)){
    exit();
}
$jsonObj = json_decode($test['test_content'], true);

$checks = [
    'check_list' => []
];
$cnt = 0;
$correct_cnt = 0;
foreach ($jsonObj as $value){
    $question_id = $value['question_id'];
    $answ = $data['answers'][$question_id];
    $cnt++;
    if ($answ == NULL || gettype($answ) != gettype($value['correctAnswer'])){
        $checks['check_list'][strval($question_id)] = false;
        continue;
    }

    $correct = false;

    switch (gettype($answ)) {
        case "string":
            $correct = (strcmp($answ, $value['correctAnswer'])) == 0;
            break;
        case 'array':
            $correct = count(array_diff($answ, $value['correctAnswer'])) == 0;
            break;
    }

    if ($correct){
        $correct_cnt++;
    }
    $checks['check_list'][strval($question_id)] = $correct;
}
$checks['right'] = $correct_cnt;
$checks['cnt'] = $cnt;

insertTestResults($pdo, $user['user_id'], $data['lab_id'], $correct_cnt, $cnt);

header('Content-type: application/json');
echo json_encode($checks);
exit();