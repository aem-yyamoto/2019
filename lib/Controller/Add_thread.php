<?php

namespace MyApp\Controller;

class Add_thread extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->addProcess();
    }

    $categoryModel = new \MyApp\Model\Category();
    $this->setValues('categories',$categoryModel->getAll());
  }

  protected function addProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\EmptyTitle $e){
      $this->setErrors('title', $e->getMessage());
    }catch(\MyApp\Exception\EmptyCategory $e){
      $this->setErrors('category', $e->getMessage());
    }

    if($this->hasError()){
      return;
    }else{
      // create thread
      try{
        $threadModel = new \MyApp\Model\Thread();
        $threadModel->create([
          'email' => $_POST['email'],
          'title' => $_POST['title'],
          'category' => $_POST['category']
        ]);
      }catch(\MyApp\Exception\DuplicateTitle $e){
        $this->setErrors('title', $e->getMessage());
        return ;
      }

      // redirect to add_thread
      header('Location: ' . SITE_URL . '/add_thread.php');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
    
    if($_POST['title'] === ""){
      throw new \MyApp\Exception\EmptyTitle();;
    }
    if($_POST['category'] === ""){
      throw new \MyApp\Exception\EmptyCategory();;
    }
  }

}