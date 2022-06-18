<?php

namespace App\Models;

/** 
 * Get hearder Authorization
 * */
class BearerToken
{

  private static function getAuthorizationHeader()
  {
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
      $headers = trim($_SERVER["Authorization"]);
      return $headers;
    }
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
      $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
      return $headers;
    }
    if (function_exists('apache_request_headers')) {
      $requestHeaders = apache_request_headers();
      $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
      if (isset($requestHeaders['Authorization'])) {
        $headers = trim($requestHeaders['Authorization']);
        return $headers;
      }
    }
    return null;
  }

  /**
   * get access token from header
   * */
  public static function getBearerToken()
  {
    $headers = self::getAuthorizationHeader();
    if (!$headers) {
      return null;
    }

    $matches = [];
    $does_it_match = preg_match('/Bearer\s(\S+)/', $headers, $matches) === 1;

    if (!$does_it_match) {
      return null;
    }

    return $matches[1];
  }
}
