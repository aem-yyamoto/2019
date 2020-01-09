<?php

namespace MyApp\Controller;

class Login_user extends \MyApp\Controller\Login {

  public function run() {
    // ゲストログインstart
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
      if(!empty($_GET['email'])){
        try{
          $userModel = new \MyApp\Model\User();
          $user = $userModel->login([
            'email' => GUEST_EMAIL
          ]);
        }catch(\MyApp\Exception\UnmatchEmailOrPassword $e){
          $this->setErrors('login', $e->getMessage());
          return ;
        }
        // login処理
        // phpはCookieでセッションidを保存する
        session_regenerate_id(true); // セッションハイジャック対策 毎回のセッションidを変換する
        $_SESSION['me'] = $user;

        // redirect to login
        header('Location: ' . SITE_URL);
        exit;
      }
    }
    // ゲストログインend

    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
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
      $this->setErrors('login', $e->getMessage());
    }

    $this->setValues('email', $_POST['email']);

    if($this->hasError()){
      return;
    }else{
      //  userModel login
      try{
        $userModel = new \MyApp\Model\User();
        $user = $userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      }catch(\MyApp\Exception\UnmatchEmailOrPassword $e){
        $this->setErrors('login', $e->getMessage());
        return ;
      }

      // login処理
      // phpはCookieでセッションidを保存する
      session_regenerate_id(true); // セッションハイジャック対策 毎回のセッションidを変換する
      $_SESSION['me'] = $user;

      // redirect to login
      header('Location: ' . SITE_URL);
      exit;
    }
  }

}