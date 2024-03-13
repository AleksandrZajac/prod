<?php

$success = '';
$errors = [];
$userLogin = '';
$password = '';

if (isset($_POST['email']) && empty($_POST['email'])) {
    array_push ($errors,'Введите емайл');
}
if (isset($_POST['password']) && empty($_POST['password'])) {
    array_push ($errors,'Введите пароль');
}

if (!empty ($_POST['email']) && !empty ($_POST['password'])) { 
    $userLogin = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']); 
    $users = getUser($pdo, $userLogin);
    setCookies($pdo, $users, $userLogin, $password);
    if (!empty($_SESSION['login'])) {
        $success = 'Вы успешно авторизованы';
    } else {
        array_push ($errors,'Неверный логин или пароль');
    }
}

if (count($errors) !== 0) {
    $isAuth = false;
} else {
    $isAuth = null;
}
if ($success){
    $isAuth = true;
}