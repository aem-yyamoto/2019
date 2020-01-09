<?php

ini_set('display_errors', 1);

define('DSN', 'mysql:dbhost=localhost;dbname=board_php');

defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
if (APPLICATION_ENV === 'development') {
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'd1cN09p8');
} else {
    define('DB_USERNAME', 'dbboard');
    define('DB_PASSWORD', 'mu4uJsif');
}


define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

define('GUEST_EMAIL', "guest@gmail.com");

require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');

session_start();