<?php

namespace App\Management;

class Token {
    public function generateToken()
    {
        $token = bin2hex(random_bytes(10));

        return $token;
    }
}
