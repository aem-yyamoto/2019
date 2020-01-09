<?php

/*
MyApp
index.php controller
MyApp\Controller\Index
-> lib/Controller/Index.php
*/

spl_autoload_register(function($class) {
    $prefix = 'MyApp\\'; // 全体の名前空間
    if (strpos($class, $prefix) === 0) {
      $className = substr($class, strlen($prefix));
      $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';
      if (file_exists($classFilePath)) {
        require $classFilePath; // fileの読み込み
      }
    }
  });