<?php

namespace MyApp\Controller;

class Edit_thread extends \MyApp\Controller {
  public function run() {
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->postProcess();
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }
    $categoryModel = new \MyApp\Model\Category();
    $this->setValues('categories',$categoryModel->getAll());
  }

  protected function postProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\EmptyTitle $e){
      $this->setErrors('title', $e->getMessage());
    }catch(\MyApp\Exception\EmptyData $e){
      $this->setErrors('category', $e->getMessage());
    }
    
    if($this->hasError()){
      // $_valuesオブジェクトにタイトルかカテゴリーの値が入る
      if($_POST['edit'] === 'title'){
        // $this->setValues('title', $_POST['title']);
      }
      elseif($_POST['edit'] === 'category'){
        // $this->setValues('category', $_POST['category']);
      }
      return;
    }else{
      // edit thread
      try{
        $threadModel = new \MyApp\Model\Thread();
        if($_POST['edit'] === 'title'){
          $update_thread = new \MyApp\Controller\Threads();
          $update_thread->update_title($_POST['title'], $_POST['thread_id']);
        }elseif($_POST['edit'] === 'category'){
          $categoryModel = new \MyApp\Model\Category();
          $new_category = $categoryModel->getCategory($_POST['category_id']);

          $update_thread = new \MyApp\Controller\Threads();
          $update_thread->update_category($new_category->category,$_POST['thread_id']);
        }elseif($_POST['edit'] === 'delete_thread'){
          $update_thread = new \MyApp\Controller\Threads();
          $update_thread->delete($_POST['thread_id']);
        }
      }catch(\MyApp\Exception\DuplicateTitle $e){
        $this->setErrors('title', $e->getMessage());
        return ;
      }

      // redirect to select_thread
      header('Location: ' . SITE_URL . '/select_thread.php');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
    
    if($_POST['edit'] === 'title'){
      if($_POST['title'] === ""){
        throw new \MyApp\Exception\EmptyTitle();;
      }
    }elseif($_POST['edit'] === 'category'){
      if($_POST['category_id'] === ""){
        throw new \MyApp\Exception\EmptyData();;
      }
    }
  }

}