<?php

namespace Tests;

use App\Models\Api;
use PHPUnit\Framework\TestCase;


class UserServiceTest extends TestCase
{
  public function testShouldLoginUser()
  {
    $user = Api::post(\LOCAL_BASE_URL_API . "user/login", [
      'email' => \LOGIN,
      'senha' => \PASSWORD
    ]);
    $user = json_decode($user);
    $this->assertIsObject($user);
    $this->assertObjectHasAttribute('status', $user);
    $this->assertSame($user->status, true);
    $this->assertObjectHasAttribute('data', $user);
    $this->assertObjectHasAttribute('token', $user->data);
    $this->assertIsString($user->data->token);
  }

  public function testShouldNotLoginUser()
  {
    $user = Api::post(\LOCAL_BASE_URL_API . "user/login", [
      'email' => "foobar",
      'senha' => "********"
    ]);
    $user = json_decode($user);
    $this->assertIsObject($user);
    $this->assertObjectHasAttribute('data', $user);
    $this->assertObjectHasAttribute('mensagem', $user->data);
    $this->assertSame('Falha na autenticação', $user->data->mensagem);
  }
}
