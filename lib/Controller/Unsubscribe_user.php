<?php

namespace MyApp\Controller;

class Unsubscribe_user extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }

    try{
      // DB usersからユーザー情報を削除
      $userModel = new \MyApp\Model\User();
      $userModel->delete([
        'email' => $_SESSION['me']->email
      ]);

      // DB articlesのflag_existをFalseにする
      $articleModel = new \MyApp\Model\Article();
      $articleModel->subscribe([
        'email' => $_SESSION['me']->email
      ]);
      $goodModel = new \MyApp\Model\Good();
      $goodModel->subscribe([
        'email' => $_SESSION['me']->email
      ]);
    }catch(\MyApp\Exception\NotEmail $e){
      $this->setErrors('email', $e->getMessage());
      return ;
    }

  }

}