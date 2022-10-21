<?php

namespace App\Models;

class Podcast
{

  public static function All($token)
  {
    return self::api_get_with_cache("programas", 'podcasts', $token);
  }

  public static function find($programa)
  {
    return self::api_get_with_cache($programa, "podcasts/$programa");
  }

  public static function episodes($id)
  {
    return self::api_get_with_cache("episodios-$id", "episodios/getById/$id");
  }


  public static function episode($slug)
  {
    return self::api_get_with_cache("$slug",  "episodios/getBySlug/$slug");
  }

  public static function comments($code, $token)
  {
    return self::api_get_with_cache("comments-$code",  "comments/$code", $token);
  }

  public static function favorites($token)
  {
    return self::api_get_with_cache("favoritos-$token", "episodios/getFavoritos", $token);
  }


  private static function api_get_with_cache($file_name, $url, $token = null)
  {
    if (!Cache::exist($file_name)) {
      $data = Api::get(\SACOCHEIO_API_BASE_URL . $url, $token);
      Cache::create($file_name, $data);
      return json_decode($data);
    }

    $cache = json_decode(Cache::get($file_name));

    Cache::check_if_cache_expired($file_name);

    return $cache;
  }
}
