<?php

namespace App\Models;

class User
{
  public static function login($email, $senha)
  {

    $response = Api::post(\SACOCHEIO_API_BASE_URL . 'login', [
      'email' => $email,
      'password' => $senha
    ]);

    
    return $response;
  }

}
