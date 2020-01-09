<?php
// 退会・ログアウト
require_once(__DIR__ . '/../config/config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Controllerがインスタンス化されないと$_SESSION['token']がセットされない！
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
        echo "Invalid Token!";
        exit;
    }
    // 退会処理
    // usersの情報を消す
    // articlesのflag_existをFalseにする
    $app = new MyApp\Controller\Unsubscribe_user();
    $app->run();

    // ログアウト処理
    $_SESSION = [];

    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(), '', time() - 86400, '/');
    }
    
    session_destroy();
}

header('Location: ' . SITE_URL); // login.phpに戻る
