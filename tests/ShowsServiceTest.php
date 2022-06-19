<?php

namespace Tests;

use \App\Services\ShowsService;
use PHPUnit\Framework\TestCase;


class ShowsServiceTest extends TestCase
{
  public function testShouldGetShowsData()
  {
    $showsService = new ShowsService();
    $shows = $showsService->get();

    $this->assertIsArray($shows);
    $this->assertSame(\count($shows), \MAX_SCHEDULE_LENGTH);
  }
}

