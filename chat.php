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

  if (!array_key_exists('post_id', $data)) {
    send_response(array(
      'code' => 422,
      'data' => 'Post ID is missing'
    ), 422);

    return;
  }

  $message = $data["message"];
  $post_id = $data["post_id"];

  $new_id = query_database("INSERT INTO Chat (message, post_id) VALUES (\"$message\", $post_id)", true);

  $db_results = query_database("SELECT * FROM Chat WHERE ID = $new_id");
  $final_results = array();

    if (mysqli_num_rows($db_results) > 0) {
    while ($row = mysqli_fetch_assoc($db_results)) {
      array_push($final_results, $row);
    }
  }

  send_response([
    'status' => 'success',
    'data' => $final_results[0]
  ]);
}
