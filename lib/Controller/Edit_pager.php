<?php

namespace MyApp\Controller;

class Edit_pager extends \MyApp\Controller {
  public function run() {
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->postProcess();
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }

    $pagerModel = new \MyApp\Model\Pager_setting();
    $this->setValues('pager', $pagerModel->getSetting());

  }
  
  protected function postProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\EmptyData $e){
      $this->setErrors('pager', $e->getMessage());
    }catch(\MyApp\Exception\NotDataType $e){
      $this->setErrors('pager', $e->getMessage());
    }catch(\MyApp\Exception\NotZero $e){
      $this->setErrors('pager', $e->getMessage());
    }
    
    if($this->hasError()){
      return;
    }else{
      // edit pager
      try{
        $pagerModel = new \MyApp\Model\Pager_setting();
        $pagerModel->update((int)$_POST['new_pager']);
      }catch(\MyApp\Exception\EmptyData $e){
        $this->setErrors('attention', $e->getMessage());
        return ;
      }catch(\MyApp\Exception\UpdateError $e){
        $this->setErrors('attention', $e->getMessage());
        return ;
      }

      // redirect to edit_pager
      header('Location: ' . SITE_URL . '/edit_pager.php');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
    if($_POST['new_pager'] === ''){
      throw new \MyApp\Exception\EmptyData();
    }
    elseif(!ctype_digit($_POST['new_pager'])){
      throw new \MyApp\Exception\NotDataType();
    }elseif($_POST['new_pager'] == 0){
      throw new \MyApp\Exception\NotZero();
    }
  }

}