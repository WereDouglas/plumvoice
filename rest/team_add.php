<?php
include '../Variables.php';
$data = json_decode(file_get_contents("php://input"));
if (empty($data->name)) {
    $errors[] = $pre_error_msg . 'Name';
}
if (empty($data->city)) {
    $errors[] = $pre_error_msg . 'City';
}
if (empty($data->state)) {
    $errors[] = $pre_error_msg . 'State';
}
if (count($errors) > 1) {
    $message['message'] = 'Failed';
    $message['errors'] = $errors;
    echo json_encode($message);
    return;
}
include '../Connection.php';
$connection = new connection();
$query = "INSERT INTO team (name,city,state) VALUES (:name,:city,:state)";
$team = [
    //TODO name should be a Unique field
    "name" => htmlspecialchars(strip_tags($data->name)),
    "city" => htmlspecialchars(strip_tags($data->city)),
    //TODO state is too long validate this
    "state" => htmlspecialchars(strip_tags($data->state)),
];
$message['message'] = $connection->save($query, $team);
echo json_encode($message);

?>