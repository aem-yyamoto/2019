<?php

namespace MyApp\Controller;

class Update_subadmin extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }
    
    // loginしていたらGETで取得したメアドからアカウント情報を取得
    $userModel = new \MyApp\Model\Admin();
    $subadmin = $userModel->findAdmin($_GET['email']);

    $this->setValues('nickname', $subadmin->nickname);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->postProcess();
    }
  }

  protected function postProcess(){
    // validate データの検証
    // update_password
    if($_POST['update'] === "password"){
      try{
        $this->_validate();
      }catch(\MyApp\Exception\InvalidPassword $e){
        $this->setErrors('now_password', $e->getMessage());
      }catch(\MyApp\Exception\UnMatchPassword $e){
        $this->setErrors('now_password', $e->getMessage());
      }catch(\MyApp\Exception\InvalidPassword $e){
        $this->setErrors('new_password', $e->getMessage());
      }

      if($this->hasError()){
        $_GET['update_password'] = null;
        return;
      }else{
        // update password of admin
        try{
          $userModel = new \MyApp\Model\Admin();
          $userModel->update_password([
            'email' => $_GET['email'],
            'password' => $_POST['new_password']
          ]);
        }catch(\MyApp\Exception\Update_Error $e){
          $this->setErrors('email', $e->getMessage());
          return ;
        }
        $_SESSION['me']->password = $userModel->findme($_SESSION['me']->email)->password;

        // redirect to update_subadmin
        $path = "?email=".$_GET['email']."&update_password=true";
        header('Location: ' . SITE_URL . '/update_subadmin.php'.$path);
        exit;
      }
    }
    // update_nickname
    elseif($_POST['update'] === "nickname"){
      try{
        $this->_validate();
      }catch(\MyApp\Exception\EmptyNickname $e){
        $this->setErrors('new_nickname', $e->getMessage());
      }

      if($this->hasError()){
        return;
      }else{
        // update nickname of admin
        try{
          $userModel = new \MyApp\Model\Admin();
          $userModel->update_nickname([
            'nickname' => $_POST['new_nickname'],
            'email' => $_GET['email']

          ]);
        }catch(\MyApp\Exception\Update_Error $e){
          $this->setErrors('new_nickname', $e->getMessage());
          return ;
        }

        // redirect to select_subadmin
        header('Location: ' . SITE_URL . '/select_subadmin.php');
        exit;
      }
    }
    // delete_subadmin
    elseif($_POST['update'] === "delete"){
      try{
        $userModel = new \MyApp\Model\Admin();
        $userModel->delete([
          'email' => $_GET['email']
        ]);
      }catch(\MyApp\Exception\Update_Error $e){
        $this->setErrors('delete', $e->getMessage());
        return ;
      }
      
      // redirect to select_subadmin
      header('Location: ' . SITE_URL . '/select_subadmin.php');
      exit;
    }

  }

  private function _validate(){
    $this->validate_token();
    
    $userModel = new \MyApp\Model\Admin();
    $subadmin = $userModel->findAdmin($_GET['email']);
    if(!empty($_POST['update'])){
      if($_POST['update'] === "password"){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
          throw new \MyApp\Exception\InvalidEmail();
        }
        
        if(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['now_password'])){
          throw new \MyApp\Exception\InvalidPassword();
        }
        // 洗濯したサブ管理者のpasswordとnow_passwordの比較
        if(!password_verify($_POST['now_password'], $subadmin->password)){
          throw new \MyApp\Exception\UnMatchPassword();
        }
        if(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['new_password'])){
          throw new \MyApp\Exception\InvalidPassword();
        }
      }elseif($_POST['update'] === "nickname"){
        if($_POST['new_nickname'] === ""){
          throw new \MyApp\Exception\EmptyNickname();
        }
      }

    }
    
  }

}