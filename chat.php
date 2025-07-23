<?php include 'helpers.php'; ?>

<?php
$method = get_method();
$data = get_request_data();

if ($method === 'POST') {
  if (!array_key_exists('message', $data)) {
    send_response(array(
      'code' => 422,
      'data' => 'Message is missing'
    ), 422);

    return;
  }

  if (!array_key_exists('type', $data)) {
    send_response(array(
      'code' => 422,
      'data' => 'Type is missing'
    ), 422);

    return;
  }

  if (!array_key_exists('post_id', $data)) {
    send_response(array(
      'code' => 422,
      'data' => 'Post ID is missing'
    ), 422);

    return;
  }

  $message = $data["message"];
  $type = $data["type"];
  $post_id = $data["post_id"];

  $new_id = query_database("INSERT INTO Chats (message, type, post_id) VALUES (\"$message\", \"$type\", \"$post_id\")", true);
  $data["id"] = strval($new_id);

  send_response([
    'status' => 'success',
    'data' => $data
  ]);
}
