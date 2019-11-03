<?php
/***TODO
 *player_id is not auto increment
 *
 **/
include '../Variables.php';
// request data
$data = json_decode(file_get_contents("php://input"));
/*convert player signed date to a valid date time */

if (empty($data->player_id)) {
    $errors[] = $pre_error_msg . 'Player ID';
}
if (empty($data->first_name)) {
    $errors[] = $pre_error_msg . 'First Name';
}
if (empty($data->last_name)) {
    $errors[] = $pre_error_msg . 'Last Name';
}
if (empty($data->signed_date)) {
    $errors[] = $pre_error_msg . 'Signed Date';
}
if (empty($data->position)) {
    $errors[] = $pre_error_msg . 'Position';
}
if (empty($data->team)) {
    $errors[] = $pre_error_msg . 'Team';
}
//FK_position
//FK_team_id
if (count($errors) > 1) {
    $message['message'] = 'Failed';
    $message['errors'] = $errors;
    echo json_encode($message);
    return;
}
$signed_date = date('Y-m-d', strtotime($data->signed_date));
$retired_date = !empty($data->retired_date) ? date('Y-m-d', strtotime($data->retired_date)) : null;

include '../Connection.php';
$connection = new Connection();
$query = "INSERT INTO player (player_id,first_name,last_name,signed_date,retired_date,FK_position,FK_team_id) VALUES (:player_id,:first_name,:last_name,:signed_date,:retired_date,:FK_position,:FK_team_id)";
$player = [
    "player_id" => htmlspecialchars(strip_tags($data->player_id)),
    "first_name" => htmlspecialchars(strip_tags($data->first_name)),
    "last_name" => htmlspecialchars(strip_tags($data->last_name)),
    "signed_date" => htmlspecialchars(strip_tags($signed_date)),
    "retired_date" => $retired_date,
    "FK_position" => htmlspecialchars(strip_tags($data->position)),
    "FK_team_id" => htmlspecialchars(strip_tags($data->team)),
];
$message['message'] = $connection->save($query, $player);
echo json_encode($message);

?>