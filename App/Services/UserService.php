<?php

namespace App\Services;

use App\Models\User;

class UserService
{
  public function login()
  {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
      return ['error' => 'Invalid data'];
    }

    if (!isset($data['email']) || !isset($data['senha'])) {
      return ['error' => 'Invalid data'];
    }

    try {
      $user = User::login($data['email'], $data['senha']);
      return json_decode($user);
    } catch (\Exception $e) {
      return ['error' => $e->getMessage()];
    }
  }
}
