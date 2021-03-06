<?php

namespace App\Services;

use App\Models\Accents;
use App\Models\Podcast;
use App\Models\BearerToken;

class PodcastService
{
  public function podcasts()
  {

    $token = BearerToken::getBearerToken();

    if (!$token) {
      return ['error' => 'Invalid token'];
    }

    $podcasts = Podcast::All($token);

    if (!$podcasts) {
      return ['error' => 'No podcasts found'];
    }

    return $podcasts;
  }

  public function podcast($name = "")
  {
    if (!$name)  return ['error' => 'No podcast name specified'];

    $name = $this->format_search_name($name);

    $podcast = Podcast::find($name);
    if (!$podcast) {
      return [
        'error' => 'Podcast not found',
        'name' => $name,
        'url' => \SACOCHEIO_API_BASE_URL . "programas/0?nomePrograma=$name"
      ];
    }

    $episodes = Podcast::episodes($name);

    if (!$episodes) {
      return [
        'error' => 'No episodes found',
        'name' => $name,
        'url' => \SACOCHEIO_API_BASE_URL . "episodios?nomePrograma=$name"
      ];
    }

    $podcast->episodes = ['data' => [], 'length' => 0];
    $podcast->episodes["data"] = $episodes;
    $podcast->episodes["length"] = \count($episodes);

    return $podcast;
  }

  public function latest_episodes_of_each_podcast()
  {
    $bearer = BearerToken::getBearerToken();

    if (!$bearer) {
      return ['error' => 'Invalid token'];
    }

    $podcasts = Podcast::All($bearer);

    if (!$podcasts) {
      return ['error' => 'No podcasts found'];
    }

    foreach ($podcasts as $key => $podcast) {
      $name =  $this->format_search_name($podcast->nome);
      $episode = Podcast::episodes($name);

      if (count($episode) > 0) {
        $podcast->latest_episode = $episode[count($episode) - 1];
      } else {
        unset($podcasts[$key]);
      }
    }

    return $podcasts;
  }

  public function episode($code = null)
  {
    if (!$code) return ['error' => 'No episode code provided'];

    $token = BearerToken::getBearerToken();

    if (!$token)  return ['error' => 'Invalid token'];

    $episode = Podcast::episode($code);

    if (!$episode) return ['error' => 'Episode not found'];


    $episode->audio = \SACOCHEIO_RSS_BASE_URL . "$episode->autor/$episode->codigo/$episode->urlMp3";

    $podcast = Podcast::find($this->format_search_name($episode->autorNome));
    $podcast->episode = $episode;

    $comments = Podcast::comments($code, $token);

    $podcast->comments = ['data' => [], 'length' => 0];

    $podcast->comments["data"] = $comments;
    $podcast->comments["length"] = \count($comments);

    return $podcast;
  }

  private function format_search_name($name)
  {
    return Accents::remove(str_replace(' ', '+', strtolower($name)));
  }
}
