<?php include 'helpers.php'; ?>

<?php
$method = get_method();
$data = get_request_data();

if ($method === 'GET') {
  $db_results = query_database("SELECT * FROM FoundPet ORDER BY created_at DESC");
  $final_results = array();

  if (mysqli_num_rows($db_results) > 0) {
    while ($row = mysqli_fetch_assoc($db_results)) {
      $id = $row["id"];
      $chat_db_results = query_database("SELECT * FROM Chat WHERE type = 'FOUND' AND post_id = $id ORDER BY created_at DESC");
      $chats = array();

      if (mysqli_num_rows($chat_db_results) > 0) {
        while ($row = mysqli_fetch_assoc($chat_db_results)) {
          array_push($chats, $row);
        }
      }

      $row["chats"] = $chats;

      array_push($final_results, $row);
    }
  }

  send_response([
    'status' => 'success',
    'data' => $final_results,
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

  $new_id = query_database("INSERT INTO FoundPet ($keys) VALUES ($values)", true);
  $data["id"] = strval($new_id);
  $data["chats"] = array();

  send_response([
    'status' => 'success',
    'data' => $data
  ]);
}
