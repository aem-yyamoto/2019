<?php
// ブラックリストに追加
require_once(__DIR__ . '/../config/config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Controllerがインスタンス化されないと$_SESSION['token']がセットされない！
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
        echo "Invalid Token!";
        exit;
    }
    // 退会処理
    // usersの情報を消す
    // articlesとgoodsのflag_existをFalseにする
    $app = new MyApp\Controller\Blacklist();
    $app->run();
}

header('Location: ' . SITE_URL . '/admin_show_users.php'); // admin_show_users.phpに戻る
