<?php

namespace MyApp\Controller;

class Edit_title extends \MyApp\Controller {
  public function run() {
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->postProcess();
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }

    $mainmenuModel = new \MyApp\Model\Mainmenu();
    $this->setValues('main', $mainmenuModel->getAll());

  }
  
  protected function postProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\EmptyTitle $e){
      $this->setErrors('title', $e->getMessage());
    }
    
    if($this->hasError()){
      return;
    }else{
      // edit title
      try{
        $mainmenuModel = new \MyApp\Model\Mainmenu();
        $mainmenuModel->update_title($_POST['new_title']);
      }catch(\MyApp\Exception\EmptyTitle $e){
        $this->setErrors('title', $e->getMessage());
        return ;
      }

      // redirect to edit_title
      header('Location: ' . SITE_URL . '/edit_title.php');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
    
    if($_POST['new_title'] === ''){
      throw new \MyApp\Exception\EmptyTitle();
    }
  }

}