<?php

namespace App\Models;

class Cache
{

  private const PATH = "cache/";
  private const TIME_TO_EXPIRED = 60 * 5;

  public static  function check_if_cache_expired($name)
  {
    $file_date = \strtotime(\date("F d Y H:i:s.", \filemtime(self::file_path($name))));
    $expired_date =  \strtotime(\date("m/d/Y h:i:s a", $file_date + self::TIME_TO_EXPIRED));
    if (\time() > $expired_date) {
      unlink(self::file_path($name));
      return;
    }
  }

  public static function create($name, $data)
  {
    self::create_cache_folder();
    \file_put_contents(self::file_path($name), $data);
  }

  public static function get($name)
  {
    return \file_get_contents(self::file_path($name));
  }

  public static function exist($name)
  {
    return !!\file_exists(self::file_path($name));
  }

  private static function create_cache_folder()
  {
    if (\is_dir(self::PATH) === false) {
      \mkdir(self::PATH);
    }
  }

  private static function file_path($name)
  {
    return  self::PATH . $name . ".json";
  }
}
