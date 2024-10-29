<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait GeneratesCredentials
{
    private function generateCredentials($name)
    {
        $parts = explode(' ', $name);
        $email = $parts[0] . '.' . $parts[1] . '@taalim.ma';
        $password = $parts[0] . '.' . $parts[1] . '.' . uniqid();

        return [
            'email' => $email,
            'password' => $password,
        ];
    }
}