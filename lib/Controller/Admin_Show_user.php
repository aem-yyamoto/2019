<?php

namespace MyApp\Controller;

class Admin_Show_user extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL . '/login_admin.php');
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
      if(!empty($_GET['email'])){
        // get users info
        $userModel = new \MyApp\Model\User();
        $this->setValues('user_info', $userModel->findUser($_GET['email']));
      }
    }
    
  }

}