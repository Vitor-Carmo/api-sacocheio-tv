<?php

namespace App\Models;

class Podcast
{

  public static function All($token)
  {
    return self::api_get_with_cache("programas", 'podcasts', $token);
  }

  public static function find($programa, $token)
  {
    return self::api_get_with_cache($programa, "podcasts/$programa", $token);
  }

  public static function episodes($id, $token)
  {
    return self::api_get_with_cache("episodios-$id-$token", "episodios/getById/$id", $token);
  }


  public static function episode($slug, $token)
  {
    return self::api_get_with_cache("$slug-$token",  "episodios/getBySlug/$slug", $token);
  }

  public static function comments($code, $token)
  {
    return self::api_get_with_cache("comments-$code",  "comments/$code", $token);
  }

  public static function favorites($token)
  {
    return self::api_get_with_cache("favoritos-$token", "episodios/getFavoritos", $token);
  }

  public static function set_favorite($episodioId, $podcastId, $token)
  {
    $data = Api::post(\SACOCHEIO_API_BASE_URL . "episodioOuvinte/setFavorite", [
      "episodioId" => $episodioId,
    ], $token);

    if (Cache::exist("episodios-$podcastId-$token")) {
      Cache::remove("episodios-$podcastId-$token");
    }

    if (Cache::exist("favoritos-$token")) {
      Cache::remove("favoritos-$token");
    }

    return json_decode($data);
  }

  public static function send_comment($comentario, $idEpisodio, $idComentarioResposta = "",  $token)
  {
    $data = Api::post(\SACOCHEIO_API_BASE_URL . "comentarios", [
      "comentario" => $comentario,
      "idComentarioResposta" => $idComentarioResposta,
      "idEpisodio" => $idEpisodio,
    ], $token);

    if (Cache::exist("comments-$idEpisodio")) {
      Cache::remove("comments-$idEpisodio");
    }

    return json_decode($data);
  }

  public static function remove_comment($commentId, $episodeId, $token)
  {
    $data = Api::delete(\SACOCHEIO_API_BASE_URL . "comentarios/$commentId", $token);

    if (Cache::exist("comments-$episodeId")) {
      Cache::remove("comments-$episodeId");
    }

    return json_decode($data);
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
