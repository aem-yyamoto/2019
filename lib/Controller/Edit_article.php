<?php

namespace MyApp\Controller;

class Edit_article extends \MyApp\Controller {
  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }

    // article_idを保持していないならスレッドに戻る
    if(!isset($_POST['article_id'])){
      // redirect to edit_article
      $path = "?select_thread=".h($_POST['select_thread'])."&select_thread_category=" . h($_POST['select_thread_category'])."&thread_id=" . h($_POST['thread_id'])."&page=" . h($_POST['page']);
      header('Location: ' . SITE_URL . '/thread.php'.$path);
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(empty($_POST['from']))
        $this->postProcess();
    }

    $this->setValues('now_text', $_POST['now_text']);
    $this->setValues('article_id', $_POST['article_id']);
    $this->setValues('thread_id', $_POST['thread_id']);
    $this->setValues('select_thread', $_POST['select_thread']);
    $this->setValues('select_thread_category', $_POST['select_thread_category']);
    $this->setValues('page', $_POST['page']);
  }

  protected function postProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\EmptyText $e){
      $this->setErrors('text', $e->getMessage());
    }
    
    if($this->hasError()){
      return;
    }else{
      // delete article
      if(isset($_POST['update']) && $_POST['update'] == "delete"){
        try{
          $this->delete_article();
          $this->delete_good();
        }catch(\MyApp\Exception\UpdateError $e){
          $this->setErrors('update', $e->getMessage());
        }
      }else{
      // edit article
        try{
          $articleModel = new \MyApp\Model\Article();
          $articleModel->update_text([
            'text' => $_POST['new_text'],
          'article_id' => $_POST['article_id'],
            'thread_id' => $_POST['thread_id']
          ]);
        }catch(\MyApp\Exception\UpdateError $e){
          $this->setErrors('text', $e->getMessage());
          return ;
        }
      }

      // redirect to edit_article
      $path = "?select_thread=".h($_POST['select_thread'])."&select_thread_category=" . h($_POST['select_thread_category'])."&thread_id=" . h($_POST['thread_id'])."&page=" . h($_POST['page']);
      header('Location: ' . SITE_URL . '/thread.php'.$path);
      exit;
    }
  }
  
  private function delete_article(){
    $articleModel = new \MyApp\Model\Article();
    $articleModel->delete([
        'article_id' => $_POST['article_id'],
        'thread_id' => $_POST['thread_id']
    ]);
  }

  private function delete_good(){
    $goodModel = new \MyApp\Model\Good();
    $goodModel->delete_all_article([
        'article_id' => $_POST['article_id'],
        'thread_id' => $_POST['thread_id']
    ]);
  }

  private function _validate(){
    $this->validate_token();

    if(empty($_POST['from'])){
      if(empty($_POST['new_text']) || $_POST['new_text'] === ""){
        // 記事削除の場合は例外処理しない
        if(!isset($_POST['update']))
          throw new \MyApp\Exception\EmptyText();
      }
    }
  }

}