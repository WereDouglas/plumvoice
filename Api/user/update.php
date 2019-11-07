<?php
//HTTP Method: PUT
//Allowed Content-Type values: application/x-www-form-urlencoded or application/json
//user_id – existing unique id for a user
// email – (optional) string, user's email address
//password – (optional) string, user's password
//confirm_password – (optional) string password confirmation, required when updating user's password
//first_name – (optional) string, user's first name
//last_name – (optional) string, user's last name
//street_number – (optional) int, user's street number
//apartment_number – (optional), int, user's apartment number
//street_name – (optional) string, user's street name
//city – (optional) string, user's city
//state – (optional) string, user's state (2 letter abbreviation)
//Response:
//The following http codes are possible:
//204 – success, account updated
//400 – invalid parameters supplied, do not submit with the same parameters
//401 – permission denied, invalid http basic credentials
//404 – user not found
//500 – internal server error
//The response body will be an application/json object (or empty) and the member variables will vary
//depending on the http code returned.
//For non-204 http codes (unsuccessful):
//error – string indicating the error
//For 204 http codes (success):
//    no body

header("Content-type: application/x-www-form-urlencoded");
header("Content-type: application/json");
include('model/user.php');
// request data
$data_json = json_decode(file_get_contents("php://input"));
$data = (empty($data_json)) ? json_decode(json_encode($_REQUEST)) : $data_json;
//var_dump($data);
//exit;
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

if (empty($data->street_name)) {
    $errors[] = $pre_error_msg . ' Street Name';
}
if (empty($data->city)) {
    $errors[] = $pre_error_msg . ' City';
}
if (empty($data->state)) {
    $errors[] = $pre_error_msg . ' State';
}
//TODO user json object state can post more than two characters
if (strlen($data->state) > 2) {
    $errors[] = ' State is a 2 letter abbreviation';
}
//TODO user json object email not validatable
if (filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = ' Invalid Email ';
}
if (count($errors) > 1) {
    http_response_code(400);
    $message['message'] = 'Failed';
    $message['errors'] = $errors;
    echo json_encode($message);
    return;
}
$password = MD5($data->password);
$apartment_number = empty($data->apartment_number) ? null : $data->apartment_number;
$user = new User();
$user->user_id = htmlspecialchars(strip_tags($id));
$user->email = htmlspecialchars(strip_tags($data->email));
$user->password = htmlspecialchars(strip_tags($password));
$user->first_name = htmlspecialchars(strip_tags($data->first_name));
$user->last_name = htmlspecialchars(strip_tags($data->last_name));
$user->street_number = htmlspecialchars(strip_tags($data->street_number));
$user->apartment_number = $apartment_number;
$user->street_name = htmlspecialchars(strip_tags($data->street_name));
$user->city = htmlspecialchars(strip_tags($data->city));
$user->state = htmlspecialchars(strip_tags($data->state));
$id = $user->Update($user);
if ( $id > 0) {
    http_response_code(201);
    echo $id;
} else {
    http_response_code(503);
    $message['Message'] = " User not saved ";
    echo json_encode($message);
}
?>