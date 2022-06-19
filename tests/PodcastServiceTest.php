<?php

namespace Tests;

use App\Models\Api;
use \App\Models\User;
use PHPUnit\Framework\TestCase;


class PodcastServiceTest extends TestCase
{
  private function getUser(){
    $user = User::login(\LOGIN, \PASSWORD);
    $user = json_decode($user);
    return $user;
  }

  public function testShouldListAllPodcasts() {
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

  public function testShouldGiveAnErrorBecauseIDidntPassTheToken() {
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
    $episode_code = 945;
    $user = $this->getUser();

    $token = $user->token;
    $this->assertIsString($token);

    $episode = Api::get(\LOCAL_BASE_URL_API . "podcast/episode/$episode_code", $token);

    $episode = json_decode($episode);

    $this->assertIsObject($episode);
    $this->assertObjectHasAttribute('status', $episode);
    $this->assertSame($episode->status, true);
    $this->assertObjectHasAttribute('data', $episode);
    $this->assertIsObject($episode->data);
    $this->assertObjectHasAttribute('episode', $episode->data);
  }

  public function testIfItShowsAnArrorWhenNotPassingTheEpisodeCode()
  {
    $episode = Api::get(\LOCAL_BASE_URL_API . "podcast/episode/");
    $episode = json_decode($episode);

    $this->assertIsObject($episode);
    $this->assertObjectHasAttribute('data', $episode);
    $this->assertIsObject($episode->data);
    $this->assertObjectHasAttribute('error', $episode->data);
  }
}
