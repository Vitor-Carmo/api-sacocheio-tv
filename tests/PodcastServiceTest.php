<?php

namespace Tests;

use App\Models\Api;
use \App\Models\User;
use PHPUnit\Framework\TestCase;


class PodcastServiceTest extends TestCase
{
  private function getUser()
  {
    $user = User::login(\LOGIN, \PASSWORD);
    $user = json_decode($user);
    return $user;
  }

  public function testShouldListAllPodcasts()
  {
    $user = $this->getUser();
    $token = $user->token;
    $this->assertIsString($token);

    $podcasts = Api::get(\LOCAL_BASE_URL_API . "podcast/podcasts", $token);
    $podcasts = json_decode($podcasts);

    $this->assertIsObject($podcasts);
    $this->assertObjectHasAttribute('status', $podcasts);
    $this->assertSame($podcasts->status, true);
    $this->assertObjectHasAttribute('data', $podcasts);
    $this->assertIsArray($podcasts->data);
    $this->assertGreaterThan(0, count($podcasts->data));
  }

  public function testShouldGiveAnErrorBecauseIDidntPassTheTokenOnListAllPodcasts()
  {
    $podcasts = Api::get(\LOCAL_BASE_URL_API . "podcast/podcasts");
    $podcasts = json_decode($podcasts);

    $this->assertIsObject($podcasts);
    $this->assertSame($podcasts->status, true);
    $this->assertObjectHasAttribute('data', $podcasts);
    $this->assertIsObject($podcasts->data);
    $this->assertObjectHasAttribute('error', $podcasts->data);
  }

  public function testShouldListFavoriteEpisodes()
  {
    $user = $this->getUser();
    $token = $user->token;
    $this->assertIsString($token);

    $favorites = Api::get(\LOCAL_BASE_URL_API . "podcast/favorites", $token);
    $favorites = json_decode($favorites);

    $this->assertIsObject($favorites);
    $this->assertSame($favorites->status, true);
    $this->assertObjectHasAttribute('data', $favorites);
    $this->assertIsArray($favorites->data);

    if (\count($favorites->data) > 0) {
      $i = 0;
      foreach ($favorites->data as $favoriteEpisode) {
        $this->assertObjectHasAttribute('episode', $favoriteEpisode);
        $this->assertIsObject($favoriteEpisode->episode);
        $this->assertSame($favoriteEpisode->episode->isFavorite, true);
        if (++$i == 3) break;
      }
    }
  }


  public function testShouldListFavoriteEpisodesWithLimit()
  {
    $user = $this->getUser();
    $token = $user->token;
    $this->assertIsString($token);

    $limit = 3;
    $favorites = Api::get(\LOCAL_BASE_URL_API . "podcast/favorites/$limit", $token);
    $favorites = json_decode($favorites);

    $this->assertIsObject($favorites);
    $this->assertSame($favorites->status, true);
    $this->assertObjectHasAttribute('data', $favorites);
    $this->assertIsArray($favorites->data);

    if (\count($favorites->data) > 0) {
      $i = 0;
      $this->assertSame(\count($favorites->data), $limit);
      foreach ($favorites->data as $favoriteEpisode) {
        $this->assertObjectHasAttribute('episode', $favoriteEpisode);
        $this->assertIsObject($favoriteEpisode->episode);
        $this->assertSame($favoriteEpisode->episode->isFavorite, true);
        if (++$i == 3) break;
      }
    }
  }

  public function testShouldGetPodcastEpisode()
  {
    $podcast =  urlencode("tarja preta fm");
    $slug = "30-tarja-preta-fm";

    $user = $this->getUser();

    $token = $user->token;
    $this->assertIsString($token);

    $episode = Api::get(\LOCAL_BASE_URL_API . "/podcast/episode/$podcast/$slug", $token);

    $episode = json_decode($episode);

    $this->assertIsObject($episode);
    $this->assertObjectHasAttribute('status', $episode);
    $this->assertSame($episode->status, true);
    $this->assertObjectHasAttribute('data', $episode);
    $this->assertIsObject($episode->data);
    $this->assertObjectHasAttribute('episode', $episode->data);
  }

  public function testIfItShowsAnErrorWhenNotPassingTheEpisodeCode()
  {
    $episode = Api::get(\LOCAL_BASE_URL_API . "podcast/episode/");
    $episode = json_decode($episode);

    $this->assertIsObject($episode);
    $this->assertObjectHasAttribute('data', $episode);
    $this->assertIsObject($episode->data);
    $this->assertObjectHasAttribute('error', $episode->data);
  }

  public function testShouldGetThePodcastAndItsEpisodesByName()
  {
    $user = $this->getUser();
    $token = $user->token;
    $this->assertIsString($token);

    $name = "desinformação";

    $podcast = Api::get(\LOCAL_BASE_URL_API . "podcast/podcast/$name?page=1", $token);
    $podcast = json_decode($podcast);

    $this->assertIsObject($podcast);
    $this->assertObjectHasAttribute('status', $podcast);
    $this->assertSame($podcast->status, true);
    $this->assertObjectHasAttribute('data', $podcast);
    $this->assertIsObject($podcast->data);
    $this->assertObjectHasAttribute('episodes', $podcast->data);
    $this->assertIsArray($podcast->data->episodes);
    $this->assertSame(\count($podcast->data->episodes), 8);
    $this->assertObjectHasAttribute('next', $podcast->data);
    $this->assertIsBool($podcast->data->next);
  }

  public function testShouldGetErrorOnDontPassPaginationToPodcast()
  {
    $user = $this->getUser();
    $token = $user->token;
    $this->assertIsString($token);

    $name = "desinformação";

    $podcast = Api::get(\LOCAL_BASE_URL_API . "podcast/podcast/$name", $token);
    $podcast = json_decode($podcast);

    $this->assertIsObject($podcast);
    $this->assertObjectHasAttribute('status', $podcast);
    $this->assertSame($podcast->status, true);
    $this->assertObjectHasAttribute('data', $podcast);
    $this->assertIsObject($podcast->data);
    $this->assertObjectHasAttribute('error', $podcast->data);
  }

  public function testShouldGiveAnErrorWhenTryingToGetPodcastWithAnEmptyName()
  {
    $name = "";
    $podcast = Api::get(\LOCAL_BASE_URL_API . "podcast/podcast/$name");
    $podcast = json_decode($podcast);

    $this->assertIsObject($podcast);
    $this->assertObjectHasAttribute('data', $podcast);
    $this->assertIsObject($podcast->data);
    $this->assertObjectHasAttribute('error', $podcast->data);
  }

  public function testShouldGetTheLatestEpisodeFromEachPodcast()
  {
    $user = $this->getUser();
    $token = $user->token;
    $this->assertIsString($token);

    $podcasts = Api::get(\LOCAL_BASE_URL_API . "podcast/latest_episodes_of_each_podcast", $token);
    $podcasts = json_decode($podcasts);

    $this->assertIsObject($podcasts);
    $this->assertObjectHasAttribute('status', $podcasts);
    $this->assertSame($podcasts->status, true);
    $this->assertObjectHasAttribute('data', $podcasts);
    $this->assertIsArray($podcasts->data);
    $this->assertGreaterThan(0, count($podcasts->data));

    foreach ($podcasts->data as $podcast) {
      $this->assertObjectHasAttribute('latest_episode', $podcast);
    }
  }

  public function testShouldToggleFavoriteEpisode()
  {
    $episodeId = 4; // desinformação
    $podcastId = 5849; // #205 - Carbono vs. Silício (part. Sérgio Sacani)

    $user = $this->getUser();

    $token = $user->token;
    $this->assertIsString($token);

    $result = Api::post(\LOCAL_BASE_URL_API . "podcast/set_favorite_toggle", [
      "episodeId" => $episodeId,
      "podcastId" => $podcastId
    ], $token);

    $result = json_decode($result);

    $this->assertIsObject($result);
    $this->assertObjectHasAttribute('status', $result);
    $this->assertSame($result->status, true);
    $this->assertObjectHasAttribute('data', $result);
    $this->assertIsObject($result->data);
    $this->assertObjectHasAttribute('result', $result->data);
    $this->assertSame($result->data->result, true);
  }
}
