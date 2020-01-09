<?php

namespace MyApp\Controller;

class Delete_category extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->deleteProcess();
    }
    
    // get category info
    $categoryModel = new \MyApp\Model\Category();
    $this->setValues('categories',$categoryModel->getAll());
  }

  protected function deleteProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\EmptyData $e){
      $this->setErrors('category', $e->getMessage());
    }

    if($this->hasError()){
      return;
    }else{
      // delete category
      try{
        $categoryModel = new \MyApp\Model\Category();
        $categoryModel->delete($_POST['category_id']);
      }catch(\MyApp\Exception\UpdateError $e){
        $this->setErrors('category', $e->getMessage());
        return ;
      }

      // redirect to delete_category
      header('Location: ' . SITE_URL . '/delete_category.php');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
    
    if($_POST['category_id'] == ""){
      throw new \MyApp\Exception\EmptyData();
    }
  }
}