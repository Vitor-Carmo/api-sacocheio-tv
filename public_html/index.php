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

if ($url[0] !== 'api') {
  return;
}


array_shift($url);

$service = 'App\Services\\' . ucfirst($url[0]) . 'Service';
array_shift($url);

//$method = strtolower($_SERVER['REQUEST_METHOD']);

if (\count($url)  < 1) {
  echo json_encode(['status' => false, 'error' => "No method specified"]);
  http_response_code(404);
  return;
}

$method = $url[0];

$params = [];

array_shift($url);
$params = $url;

if (!class_exists($service)) {
  echo json_encode(['status' => false, 'error' => "Service not found"]);
  http_response_code(404);
  return;
}

if(!method_exists($service, $method)) {
  echo json_encode(['status' => false, 'error' => "Method not found"]);
  http_response_code(404);
  return;
}

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
