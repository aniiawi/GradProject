<?php
require_once "additional/auth.php";
$pdo = pdoconnect();
$user = simplecoockieauth($pdo, true);
if ($user === false || $user['role_id'] > 2) {
    f_exit();
}

if (!isset($_GET['group_id']) || empty($_GET['group_id'])){
    header("Location: /index.php");
    exit();
}

if (!isset($_GET['code_cnt']) || empty($_GET['code_cnt'])){
    header("Location: /index.php");
    exit();
}
header('Content-type: application/txt');
header('Content-Disposition: attachment; filename="codes'.strval($_GET['group_id']).'.txt"');

for ($i=0; $i<(intval($_GET['code_cnt'])); $i++){
    $code = genstring(7, true);
    while (true){
        try {
            insertregcode(pdoconnect(), $code , $_GET['group_id']);
            break;
        }catch (Exception $e){
            $code = genstring(7, true);
        }
    }
    echo strval($i).": ".$code."\r\n";
}