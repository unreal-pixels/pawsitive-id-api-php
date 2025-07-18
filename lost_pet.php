<?php include 'helpers.php'; ?>

<?php
$method = get_method();
$data = get_request_data();

function remove_empty_string($var)
{
  return $var != "";
}

if ($method === 'GET') {
  $db_results = query_database("SELECT * FROM LostPet");
  $final_results = array();

  if (mysqli_num_rows($db_results) > 0) {
    while ($row = mysqli_fetch_assoc($db_results)) {
      array_push($final_results, $row);
    }
  }

  send_response([
    'status' => 'success',
    'data' => array_reverse($final_results)
  ]);
}

if ($method === 'POST') {
  $all_keys = array();
  $all_values = array();

  foreach ($data as $key => $value) {
    array_push($all_keys, $key);

    $final_value = $value;

    if (gettype($value) === 'string') {
      $final_value = "\"$value\"";
    }

    array_push($all_values, $final_value);
  }

  $keys = implode(", ", $all_keys);
  $values = implode(", ", $all_values);

  $new_id = query_database("INSERT INTO LostPet ($keys) VALUES ($values)", true);
  $data["id"] = strval($new_id);

  send_response([
    'status' => 'success',
    'data' => $data
  ]);
}
