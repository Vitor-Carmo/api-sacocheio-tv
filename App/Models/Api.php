<?php

namespace App\Models;

class Api
{

  public static function post($url, $data, $token = null)
  {
    $ch = curl_init($url);

    $authorization = "Authorization: Bearer $token";

    $body = json_encode($data);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', $authorization]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);
    return $response;
  }


  public static function get($url, $token = null)
  {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if ($token) {
      $authorization = "Authorization: Bearer $token";
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', $authorization]);
    }

    $response = curl_exec($ch);

    curl_close($ch);

    return $response;
  }

  public static function delete($url, $token = null)
  {
    $ch = curl_init();

    $authorization = "Authorization: Bearer $token";


    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      ['Content-Type:application/json', $authorization]
    );

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
  }
}
