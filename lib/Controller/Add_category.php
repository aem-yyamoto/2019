<?php

namespace MyApp\Controller;

class Add_category extends \MyApp\Controller {

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
    $categoryModel = new \MyApp\Model\Category();
    $this->setValues('categories',$categoryModel->getAll());
  }

  protected function postProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\EmptyData $e){
      $this->setErrors('category', $e->getMessage());
    }

    if($this->hasError()){
      return;
    }else{
      // create category
      try{
        $categoryModel = new \MyApp\Model\Category();
        $categoryModel->create($_POST['category']);
      }catch(\MyApp\Exception\DuplicateCategory $e){
        $this->setErrors('category', $e->getMessage());
        return ;
      }

      // redirect to add_category
      header('Location: ' . SITE_URL . '/add_category.php');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
    
    if($_POST['category'] == ""){
      throw new \MyApp\Exception\EmptyData();
    }
  }
}