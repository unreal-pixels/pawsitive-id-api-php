<?php
// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: Content-Type, Accept');

function get_method()
{
  return $_SERVER['REQUEST_METHOD'];
}

function get_request_data()
{
  return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

function send_response($response, $code = 200)
{
  http_response_code($code);
  header('Content-Type: application/json');
  die(json_encode($response));
}

function get_env($key)
{
  $env = parse_ini_file('../../../secrets/pawsitive-id.txt');
  return $env[$key];
}

function query_database($query, $return_last_id = false)
{
  $connection = new mysqli(get_env('DB_HOST'), get_env('DB_USERNAME'), get_env('DB_PASSWORD'), get_env('DB_DATABASE'));

  if ($connection->connect_error) {
    return "ERROR";
  }

  $result = $connection->query($query);
  $last_id = $connection->insert_id;
  $connection->close();

  return $return_last_id ? $last_id : $result;
}
