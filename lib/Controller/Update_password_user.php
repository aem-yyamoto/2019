<?php

namespace MyApp\Controller;

class Update_password_user extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }
    
    if(isset($_GET['update'])){
      $this->setValues('update', true);
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->postProcess();
    }
  }

  protected function postProcess(){
    // validate データの検証
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
      $_GET['update'] = null;
      return;
    }else{
      // update password of user
      try{
        $userModel = new \MyApp\Model\User();
        $userModel->update_password([
          'email' => $_POST['email'],
          'password' => $_POST['new_password']
        ]);
      }catch(\MyApp\Exception\DuplicateEmail $e){
        $this->setErrors('email', $e->getMessage());
        return ;
      }
      $_SESSION['me']->password = $userModel->findUser($_SESSION['me']->email)->password;

      // redirect to update_password_user
      header('Location: ' . SITE_URL . '/update_password_user.php?update=true');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
    
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      throw new \MyApp\Exception\InvalidEmail();
    }
    // ユーザーのpasswordとnow_passwordの比較
    if(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['now_password'])){
      throw new \MyApp\Exception\InvalidPassword();
    }
    
    if(!password_verify($_POST['now_password'], $_SESSION['me']->password)){
      throw new \MyApp\Exception\UnMatchPassword();
    }
    if(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['new_password'])){
      throw new \MyApp\Exception\InvalidPassword();
    }
  }

}