<?php

namespace MyApp\Exception;

class InBlacklist extends \Exception{
    protected $message = 'このメールアドレスは使えません!';
}
