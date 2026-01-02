<?php namespace App\Controllers;

class HashController extends BaseController
{
    public function generate()
    {
        $passwords = [
            'password123', // USG Admin
            'orgpassword', // Campus Org User
            'handlerpass'  // Event Handler
        ];

        foreach ($passwords as $password) {
            echo "Password: $password <br>";
            echo "Hashed: " . password_hash($password, PASSWORD_DEFAULT) . "<br><br>";
        }
    }
}
