<?php

namespace MyApp\Controller;

class Login_admin extends \MyApp\Controller\Login {

  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL . '/management.php');
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->postProcess();
    }
  }

  protected function postProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\EmptyPost $e){
      $this->setErrors('login_admin', $e->getMessage());
    }

    // 入力したemailが消えないよに保存
    $this->setValues('email', $_POST['email']);

    if($this->hasError()){
      return;
    }else{
      //  admin login
      try{
        $adminModel = new \MyApp\Model\Admin();
        $admin = $adminModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      }catch(\MyApp\Exception\UnmatchEmailOrPassword $e){
        $this->setErrors('login_admin', $e->getMessage());
        return ;
      }catch(\MyApp\Exception\UnAdminUser $e){
        $this->setErrors('login_admin', $e->getMessage());
        return ;
      }

      // login処理
      // phpはCookieでセッションidを保存する
      session_regenerate_id(true); // セッションハイジャック対策 毎回のセッションidを変換する
      $_SESSION['me'] = $admin;

      // redirect to management
      header('Location: ' . SITE_URL . '\management.php');
      exit;
    }
  }

}