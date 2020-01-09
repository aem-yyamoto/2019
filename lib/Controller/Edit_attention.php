<?php

namespace MyApp\Controller;

class Edit_attention extends \MyApp\Controller {
  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->postProcess();
    }

    $mainmenuModel = new \MyApp\Model\Mainmenu();
    $this->setValues('main', $mainmenuModel->getAll());

  }

  protected function postProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\Exception $e){
      $this->setErrors('title', $e->getMessage());
    }
    
    if($this->hasError()){
      return;
    }else{
      // edit attention
      try{
        $mainmenuModel = new \MyApp\Model\Mainmenu();
        $mainmenuModel->update_attention($_POST['new_attention']);
      }catch(\MyApp\Exception\Exception $e){
        $this->setErrors('title', $e->getMessage());
        return ;
      }

      // redirect to edit_attention
      header('Location: ' . SITE_URL . '/edit_attention.php');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
  }

}