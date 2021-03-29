<?php


require "basicdbfuncs.php";


function makehsstr($str)
{
    return hash('sha256', $str . $_SERVER['REMOTE_ADDR']);
}


function simpleauthpost($pdo)
{
    if (!isset($_POST['submit'])) {
        return NULL;
    }

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        return ['err' => "Ошибка в запросе"];
    }

    if (empty($_POST['username']) || empty($_POST['password'])) {
        return ['err' => "Не все поля заполнены"];
    }

    $login = strtolower(trim($_POST['username']));
    $user = getuserbylogin($pdo, $login);


    if (!isset($user) || empty($user) || $user === false) {
        return ['err' => "Ошибка в логине или пароле"];
    }

    if (!password_verify(trim($_POST['password']), $user['user_password'])) {
        return ['err' => "Ошибка в логине или пароле"];
    }

    $hs = genstring(26, true);

    if (!setuserhsbyid($pdo, $user['user_id'], makehsstr($hs))) {
        return ['err' => "Ошибка входа"];
    }

    setcookie("id", $user['user_id'], time()+604800);
    setcookie("hs", $hs, time()+604800);
    return true;
}


function simplecoockieauth($pdo, $ret_full=false)
{
    if (!isset($_COOKIE['id']) || !isset($_COOKIE['hs'])) {
        return false;
    }

    if (empty($_COOKIE['id']) || empty($_COOKIE['hs'])) {
        return false;
    }

    $user = getuserbyid($pdo, $_COOKIE['id']);

    if (!isset($user) || empty($user) || $user === false) {
        return false;
    }

    if (strcmp(makehsstr($_COOKIE['hs']), $user['user_hash']) === 0) {
        if ($ret_full){
            return $user;
        }
        return true;
    }
    return false;
}

function f_exit(){
    setcookie("id", "", -1);
    setcookie("hs", "", -1);
    header("Location: /login.php");
    exit();
}

function register_($pdo){
    //ищем код регистрации
    if(strcmp(trim($_POST['password']), trim($_POST['password2']))!==0){
            return ['err' => "Пароли не совпадают"];
       }
    $reg_params = getregbycode($pdo, trim($_POST['reg-id']));
    if (!isset($reg_params) || empty($reg_params) || $reg_params === false) {
        return ['err' => "Регистрационный код не найден"];
    }

    //ишем хеш от пароля --не збыть
    $pass_hash = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    //создаем пользователя
    $login = strtolower(trim($_POST['username']));
    $user_id = createnewuser($pdo, $login, $pass_hash, $reg_params['group_id']);
    setuserfio($pdo, $user_id, trim($_POST['fio-input']));
    setstudentrole($pdo, $user_id);
    //удалляем код регистрации
    deleteregcode($pdo, $reg_params['id']);
    return true;
}

function register($pdo){
    if (!isset($_POST['submit'])) {
        return NULL;
    }
    //проверяем все ли поля заполнены
    if (!isset($_POST['reg-id']) || !isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['fio-input'])) {
        return ['err' => "Ошибка в запросе"];
    }

    if (empty($_POST['reg-id']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['fio-input'])) {
        return ['err' => "Не все поля заполнены"];
    }

    try {
        //начинаем транзакцию
        $pdo->beginTransaction();
        $ret_op = register_($pdo);
        //завершаем транзакцию
        $pdo->commit();
    }catch (PDOException $e){
        $pdo->rollback();
        return ['err' => "Пользователь сущетвует"];
    }
    return $ret_op;
}




