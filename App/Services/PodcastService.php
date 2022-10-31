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
      ];
    }

    $episodes = Podcast::episodes($podcast->id);

    if (!$episodes) {
      return [
        'error' => 'No episodes found',
        'name' => $name,
      ];
    }

    $page = isset($_GET['page']) ? $_GET["page"] - 1 : null;


    if ($page === false) {
      return [
        'error' => 'No page number was passed in the url',
      ];
    }

    $episodes_paged = array_chunk($episodes, 8, false);

    $hasEpisodes =  array_key_exists($page, $episodes_paged);

    if (!$hasEpisodes) {
      return [
        'error' => "page number '$page' does not exist",
      ];
    }

    $podcast->episodes = $episodes_paged[$page];
    $podcast->next = array_key_exists($page + 1, $episodes_paged);

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
      $episode = Podcast::episodes($podcast->id);
      if (count($episode) > 0) {
        $podcast->latest_episode = reset($episode);
      } else {
        unset($podcasts[$key]);
      }
    }

    return $podcasts;
  }

  public function episode($podcast, $slug = null)
  {
    if (!$podcast) return ['error' => 'No podcast name provided'];

    if (!$slug) return ['error' => 'No episode slug provided'];

    $token = BearerToken::getBearerToken();

    if (!$token)  return ['error' => 'Invalid token'];

    $episode = Podcast::episode($slug);

    if (!$episode) return ['error' => 'Episode not found'];

    $episode->audio = str_replace(\SACOCHEIO_PORTAL_BASE_URL  . "programacao/uploads/", \SACOCHEIO_RSS_BASE_URL, $episode->urlMp3);

    $podcast = Podcast::find($this->format_search_name($podcast));

    $podcast->episode = $episode;

    $comments = Podcast::comments($episode->id, $token);

    $podcast->comments = ['data' => [], 'length' => 0];

    $podcast->comments["data"] = $comments;
    $podcast->comments["length"] = \count($comments);

    return $podcast;
  }

  public function favorites($limit = null)
  {
    $token = BearerToken::getBearerToken();

    if (!$token) {
      return ['error' => 'Invalid token'];
    }

    $favoriteEpisodes = Podcast::favorites($token);


    $favoriteEpisodes = $favoriteEpisodes->episodiosFavoritos;

    $podcast = [];

    foreach ($favoriteEpisodes as $key => $episode) {
      $podcast[$key] = Podcast::find($episode->podcastName);
      $podcast[$key]->episode = $episode;
      if ($key + 1 == $limit) break;
    }

    return $podcast;
  }

  public function set_favorite_toggle()
  {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
      return ['error' => 'Invalid data'];
    }

    if (!isset($data['episodeId'])) {
      return ['error' => 'Invalid data: episodeId has not been passed'];
    }

    $token = BearerToken::getBearerToken();

    if (!$token) {
      return ['error' => 'Invalid token'];
    }

    try {
      $result = Podcast::set_favorite($data['episodeId'], $token);
      return $result;
    } catch (\Exception $e) {
      return ['error' => $e->getMessage()];
    }
  }

  private function format_search_name($name)
  {
    return Accents::remove(str_replace(' ', '', strtolower($name)));
  }
}
