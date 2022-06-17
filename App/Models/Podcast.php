<?php

namespace App\Models;

class Podcast
{

  public static function All($token)
  {
    $data = Api::get(\SACOCHEIO_API_BASE_URL . 'programas', $token);
    return json_decode($data);
  }

  public static function find($programa)
  {
    $data = Api::get(\SACOCHEIO_API_BASE_URL . "programas/0?nomePrograma=$programa");
    return json_decode($data);
  }

  public static function episode($programa)
  {
    $data = Api::get(\SACOCHEIO_API_BASE_URL . "episodios?nomePrograma=$programa");
    return json_decode($data);
  }
}
