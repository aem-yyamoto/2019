<?php

namespace MyApp\Exception;

class UnAdminUser extends \Exception{
    protected $message = 'You are not Admin!';
}