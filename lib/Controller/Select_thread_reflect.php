<?php

namespace MyApp\Controller;

class Select_thread_reflect extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }
    // get threads info
    $threadModel = new \MyApp\Model\Thread();
    $this->setValues('threads', $threadModel->findAll());

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->reflectProcess();
    }
  }

  protected function reflectProcess(){
    try{
      $update_thread = new \MyApp\Controller\Threads();
      $update_thread->update_flag_reflect($_POST['flag_reflect'], $_POST['thread_id']);
    }catch(\MyApp\Exception\UpdateError $e){
       $this->setErrors('update', $e->getMessage());
      return ;
    }

    // redirect to select_thread_reflect
    header('Location: ' . SITE_URL . '/select_thread_reflect.php');
    exit;
  }

}