<?php

namespace App\Services;

use App\Models\User;

class UserService
{
  public function login()
  {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
      return array('error' => 'Invalid data');
    }

    if (!isset($data['email']) || !isset($data['senha'])) {
      return array('error' => 'Invalid data');
    }

    try {
      $user = User::login($data['email'], $data['senha']);
      return json_decode($user);
    } catch (\Exception $e) {
      return array('error' => $e->getMessage());
    }
  }
}
