<?php

namespace App\Models;

class Podcast
{
  public static function All($token)
  {
    $data = Api::get(\SACOCHEIO_API_BASE_URL . 'podcasts', $token);
    return json_decode($data);
  }

  public static function find($programa)
  {
    $data = Api::get(\SACOCHEIO_API_BASE_URL . "podcasts/$programa");
    return json_decode($data);
  }

  public static function episodes($id)
  {
    $data = Api::get(\SACOCHEIO_API_BASE_URL . "episodios/getById/$id");
    return json_decode($data);
  }


  public static function episode($code)
  {
    $data = Api::get(\SACOCHEIO_API_BASE_URL . "episodios/getBySlug/$code");
    return json_decode($data);
  }

  public static function comments($code, $token)
  {
    $data = Api::get(\SACOCHEIO_API_BASE_URL . "comments/$code", $token);
    return json_decode($data);
  }
}
