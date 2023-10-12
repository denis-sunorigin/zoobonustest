<?php

use Models\User;

    require_once('helpers.php');

    function render($error = '', $message = '') {
        if (empty($error)) {
            include('templates/login.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isAuthorized()) header("Location: index.php");
    render();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $REQUEST_DATA = $_POST;
    $login = array_key_exists("login", $REQUEST_DATA) ? htmlspecialchars($REQUEST_DATA["login"] ?? '') : '';
    $password = array_key_exists("password", $REQUEST_DATA) ? $REQUEST_DATA["password"] ?? '' : '';
    if (empty($login) || empty($password)) {
        unset($password);
        render('', 'Отримано пустий логін або пароль під час запиту. Переконайтесь, що облікові дані коректно заповнені.');
    } else {
        $hash = hash('sha256', $password);
        unset($password);
        $userObj = new User();
        $authResult = $userObj->VerifyLoginPassword($login, $hash);
        if ($authResult["success"]) {
            session_start();
            $_SESSION["authorized"] = $login;
            header("Location: index.php");
        } else {
            session_destroy();
            render('', $authResult["message"]);
        }
    }
}

?>