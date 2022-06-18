<?php
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Content-Type: application/json');

require_once '../vendor/autoload.php';


if (!isset($_GET['url'])) {
  echo json_encode(['status' => false, 'error' => "No url specified"]);
  return;
}


$url = explode('/', $_GET['url']);

if ($url[0] !== 'api') return;


array_shift($url);
$service = 'App\Services\\' . ucfirst($url[0]) . 'Service';

if (!class_exists($service)) {
  echo json_encode(['status' => false, 'error' => "Service not found"]);
  http_response_code(404);
  exit;
}

array_shift($url);

$method = !$url ? null : $url[0];

if (!method_exists($service, $method)) {
  echo json_encode(['status' => false, 'error' => "Method not found"]);
  http_response_code(404);
  exit;
}

$params = [];
array_shift($url);
$params = $url;

try {
  $response = call_user_func_array([new $service, $method], $params);
  http_response_code(200);
  echo json_encode(['status' => true, 'data' => $response], JSON_UNESCAPED_UNICODE);
  exit;
} catch (\Exception $e) {
  http_response_code(404);
  echo json_encode(['status' => false, 'data' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
  exit;
}
