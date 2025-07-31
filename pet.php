<?php include 'helpers.php'; ?>

<?php
$method = get_method();
$data = get_request_data();

function get_single_item($id)
{
  $db_results = query_database("SELECT * FROM Pet WHERE ID = $id");
  $final_results = array();

  if (mysqli_num_rows($db_results) > 0) {
    while ($row = mysqli_fetch_assoc($db_results)) {
      $id = $row["id"];
      $chat_db_results = query_database("SELECT * FROM Chat WHERE post_id = $id ORDER BY created_at DESC");
      $chats = array();

      if (mysqli_num_rows($chat_db_results) > 0) {
        while ($chat_row = mysqli_fetch_assoc($chat_db_results)) {
          array_push($chats, $chat_row);
        }
      }

      $row["reunited"] = $row["reunited"] === "1" ? true : false;
      $row["chats"] = $chats;
      $row["images"] = empty($row["image_data"]) ? array() : explode("~", $row["image_data"]);
      $row["reunited_images"] = empty($row["reunited_image_data"]) ? array() : explode("~", $row["reunited_image_data"]);
      unset($row["image_data"]);

      array_push($final_results, $row);
    }
  }

  send_response([
    'status' => 'success',
    'data' => $final_results[0],
  ]);
}

if ($method === 'GET') {
  if (get_query_string("id")) {
    get_single_item(get_query_string("id"));

    return;
  }

  $show_reunited = !!get_query_string("reunited");
  $query_string = "SELECT * FROM Pet";

  if (!$show_reunited) {
    $query_string = $query_string . " WHERE reunited = false ORDER BY created_at DESC";
  } else {
    $query_string = $query_string . " WHERE reunited = true ORDER BY reunited_date DESC";
  }

  $db_results = query_database($query_string);

  $final_results = array();

  if (mysqli_num_rows($db_results) > 0) {
    while ($row = mysqli_fetch_assoc($db_results)) {
      $id = $row["id"];
      $chat_db_results = query_database("SELECT * FROM Chat WHERE post_id = $id ORDER BY created_at DESC");
      $chats = array();

      if (mysqli_num_rows($chat_db_results) > 0) {
        while ($chat_row = mysqli_fetch_assoc($chat_db_results)) {
          array_push($chats, $chat_row);
        }
      }

      $row["reunited"] = $row["reunited"] === "1" ? true : false;
      $row["chats"] = $chats;
      $row["images"] = empty($row["image_data"]) ? array() : explode("~", $row["image_data"]);
      $row["reunited_images"] = empty($row["reunited_image_data"]) ? array() : explode("~", $row["reunited_image_data"]);
      unset($row["image_data"]);

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
    $final_value = $value;

    if ($key === "images") {
      if (is_array($final_value)) {
        array_push($all_keys, "image_data");
        $final_value = implode("~", $final_value);
        array_push($all_values, "\"$final_value\"");
      }
    } else {
      if (gettype($value) === 'string') {
        $final_value = "\"$value\"";
      }

      array_push($all_keys, $key);
      array_push($all_values, $final_value);
    }
  }

  $keys = implode(", ", $all_keys);
  $values = implode(", ", $all_values);

  $new_id = query_database("INSERT INTO Pet ($keys) VALUES ($values)", true);

  get_single_item($new_id);
}

if ($method === 'PUT') {
  $id = get_query_string("id");

  if (!$id) {
    send_response(array(
      'code' => 422,
      'data' => 'Must set id via query param'
    ), 422);

    return;
  }

  $reunited_images = "";

  if (is_array($data["reunited_images"])) {
    $reunited_images = implode("~", $data["reunited_images"]);
  }

  $reunited_value = $data["reunited"] ? "true" : "false";
  $reunited_date = $data["reunited_date"];
  $reunited_description = $data["reunited_description"];
  $name = $data["name"];

  query_database("UPDATE Pet SET reunited = $reunited_value, reunited_image_data = \"$reunited_images\", reunited_date = \"$reunited_date\", reunited_description = \"$reunited_description\", name = \"$name\" WHERE id = $id;");

  send_response([
    'status' => 'success',
  ]);
}

if ($method === 'DELETE') {
  $id = get_query_string("id");

  if (!$id) {
    send_response(array(
      'code' => 422,
      'data' => 'Must set id via query param'
    ), 422);

    return;
  }

  query_database("DELETE FROM Pet WHERE id=\"$id\"");

  send_response([
    'status' => 'success',
  ]);
}