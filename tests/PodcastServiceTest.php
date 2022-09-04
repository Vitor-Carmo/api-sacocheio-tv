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
    $name = "desinformação";

    $podcast = Api::get(\LOCAL_BASE_URL_API . "podcast/podcast/$name");
    $podcast = json_decode($podcast);

    $this->assertIsObject($podcast);
    $this->assertObjectHasAttribute('status', $podcast);
    $this->assertSame($podcast->status, true);
    $this->assertObjectHasAttribute('data', $podcast);
    $this->assertIsObject($podcast->data);
    $this->assertObjectHasAttribute('episodes', $podcast->data);
    $this->assertIsObject($podcast->data->episodes);
    $this->assertObjectHasAttribute('data', $podcast->data->episodes);
    $this->assertIsArray($podcast->data->episodes->data);
    $this->assertObjectHasAttribute('length', $podcast->data->episodes);
    $this->assertIsInt($podcast->data->episodes->length);
    $this->assertSame($podcast->data->episodes->length, count($podcast->data->episodes->data));
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
}
