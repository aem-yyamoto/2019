<?php

namespace MyApp\Controller;

class Show_user_info extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }elseif($_SESSION['me']->email == GUEST_EMAIL){ // ゲストは弾く
      header('Location: ' . SITE_URL );
      exit;
    }

    if(!empty($_SESSION['me']->email)){
      // get users info
      $userModel = new \MyApp\Model\User();
      $this->setValues('user_info', $userModel->findUser($_SESSION['me']->email));
    }
  }
}