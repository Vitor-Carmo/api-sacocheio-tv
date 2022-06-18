<?php

namespace App\Services;

class ShowsService
{
  public function get()
  {
    $content = file_get_contents(\SHOWS_ARTHUR_PETRY);

    $regex01 = "/<div class='area01'(.*?)>(.*?)<\/div>/s";
    $regex02 = "/<div class='area02'(.*?)>(.*?)<\/div>/s";
    $regex03 = "/<div class='area03'(.*?)>(.*?)<\/div>/s";


    preg_match_all($regex01, $content, $date);
    preg_match_all($regex02, $content, $hour);
    preg_match_all($regex03, $content, $place);

    $schedule = [];

    for ($i = 0; $i < \MAX_SCHEDULE_LENGTH; $i++) {
      $schedule[$i] = [
        'place' => strip_tags($place[2][$i]),
        'date' =>  strip_tags(str_replace("&nbsp", " ", $date[2][$i])),
        'hour' => strip_tags($hour[2][$i]),
      ];
    }

    return $schedule;
  }
}
