<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(isset($_POST['form']) && $_POST['form'] == "serch_threads"){
        $categoryModel = new \MyApp\Model\Category();
        $category = $categoryModel->getCategory($_POST['category_id']);
        $this->setValues('serch_category',$category->category);
        $threadModel = new \MyApp\Model\Thread();
        $this->setValues('serch_threads', $threadModel->findThreads($category->category));
      }
    }

    // get users info
    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->findAll());
    // get threads info
    $threadModel = new \MyApp\Model\Thread();
    $this->setValues('threads', $threadModel->findAll());
    // get articles info
    $articleModel = new \MyApp\Model\Article();
    $this->setValues('articles', $articleModel->findAll());
    // get mains info
    $mainmenuModel = new \MyApp\Model\Mainmenu();
    $this->setValues('main', $mainmenuModel->getAll());
    // get category info
    $categoryModel = new \MyApp\Model\Category();
    $this->setValues('categories',$categoryModel->getAll());
  }

}