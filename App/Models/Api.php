<?php

namespace App\Models;

class Api
{

  public static function post($url, $data, $token = null)
  {
    // cria um resource cURL
    $ch = curl_init($url);


    $authorization = "Authorization: Bearer $token";
    // monte um array que conterá os campos a serem enviados
    // Vamos neste tutorial optar por usar um array para montar os campos de post. Este é o campo de form-data.
    // Nossa api específica espera um array em formato JSON com uma única chave "text" e seu respectivo conteúdo que será analisado.

    // vamos usar a função json encode para transformar nosso array em uma string Json válida
    $body = json_encode($data);

    // agora vamos anexar o corpo em formato json da sua requisição
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

    // defina o conteúdo do envio como json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));

    // ative o recebimento de retorno da requisição
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // executa a requisição POST
    $response = curl_exec($ch);

    // encerra conexão e libera variável
    curl_close($ch);
    return $response;
  }


  public static function get($url, $token=null)
  {
    // cria um resource cURL
    $ch = curl_init($url);

    $authorization = "Authorization: Bearer $token";
    
    // ativa o retorno do conteúdo da requisição
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
    // executa a requisição GET
    $response = curl_exec($ch);

    // encerra conexão e libera variável
    curl_close($ch);

    return $response;
  }
}
