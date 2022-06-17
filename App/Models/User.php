<?php

namespace App\Models;

class User
{
  public static function login($email, $senha)
  {
    $reponse = Api::post(\SACOCHEIO_API_BASE_URL . 'login', [
      'email' => $email,
      'senha' => $senha
    ]);

    return $reponse;
  }

}
