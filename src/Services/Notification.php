<?php

namespace App\Services;

class Notification{
    private $email;
    public function __construct($email)
    {
        $this->email=$email;
    }

    public function sendNotification(){


    }
}