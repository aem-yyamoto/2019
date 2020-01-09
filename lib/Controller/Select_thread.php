<?php

namespace MyApp\Controller;

class Select_thread extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }

    // get users info
    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->findAll());
    // get threads info
    $threadModel = new \MyApp\Model\Thread();
    $this->setValues('threads', $threadModel->findAll());
    // get articles info
    $articleModel = new \MyApp\Model\Article();
    $this->setValues('articles', $articleModel->findAll());
  }

}