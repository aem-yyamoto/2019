<?php

namespace MyApp\Controller;

class Select_user_reflect extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }
    // get users info
    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->findAll());

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->reflectProcess();
    }
  }

  protected function reflectProcess(){
    try{
      $userModel = new \MyApp\Model\User();
      $userModel->update_flag_reflect([
        'flag_reflect' => $_POST['flag_reflect'],
        'email' => $_POST['email']
      ]);
    }catch(\MyApp\Exception\UpdateError $e){
       $this->setErrors('update', $e->getMessage());
      return ;
    }

    // redirect to select_user_reflect
    header('Location: ' . SITE_URL . '/select_user_reflect.php');
    exit;
  }

}