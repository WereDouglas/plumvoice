<?php

include('../Header.php');
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json;charset=UTF-8");
header("Content-type: application/x-www-form-urlencoded");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include '../Variables.php';
include('User.php');
// request data
$data = json_decode(file_get_contents("php://input"));
if (empty($data->email)) {
    $errors[] = $pre_error_msg . ' Email';
}
if (empty($data->password)) {
    $errors[] = $pre_error_msg . ' Password';
}
if (empty($data->first_name)) {
    $errors[] = $pre_error_msg . 'First Name';
}
if (empty($data->last_name)) {
    $errors[] = $pre_error_msg . 'Last Name';
}

if (empty($data->street_number)) {
    $errors[] = $pre_error_msg . ' Street Number';
}
if (empty($data->apartment_number)) {
    $errors[] = $pre_error_msg . ' Apartment Number';
}
if (empty($data->street)) {
    $errors[] = $pre_error_msg . ' Street';
}
if (empty($data->city)) {
    $errors[] = $pre_error_msg . ' City';
}
if (empty($data->state)) {
    $errors[] = $pre_error_msg . ' State';
}
if (strlen($data->state)>2) {
    $errors[] = ' State is  2 letter abbreviation';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $errors[] = ' Invalid Email ';

}
if (count($errors) > 1) {
    $message['message'] = 'Failed';
    $message['errors'] = $errors;
    echo json_encode($message);
    return;
}
$password = MD5($data->password);
$user = new User();

$user->email = htmlspecialchars(strip_tags($data->email));
$user->password = htmlspecialchars(strip_tags($password));
$user->first_name = htmlspecialchars(strip_tags($data->first_name));
$user->last_name = htmlspecialchars(strip_tags($data->last_name));
$user->street_number = htmlspecialchars(strip_tags($data->street_number));
$user->apartment_number = htmlspecialchars(strip_tags($data->apartment_number));
$user->street_name = htmlspecialchars(strip_tags($data->street_name));
$user->city = htmlspecialchars(strip_tags($data->city));
$user->state = htmlspecialchars(strip_tags($data->state));

if ($user->save($user)) {

    http_response_code(201);
    $message = "Information saved ";
    echo json_encode($message);

} else {
    http_response_code(503);
    $message['Message'] = " User not saved ";
    echo json_encode($message);
}
?>