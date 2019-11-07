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

$update = "UPDATE user SET";
$where = " WHERE user_id = " . $id;
if (!empty($data->password)) {
    $password = MD5(htmlspecialchars(strip_tags($data->password)));
    $res = $user->Update($update . " password = :password" . $where, ["password" => $password]);
}
if (!empty($data->street_number)) {
    $street_number = htmlspecialchars(strip_tags($data->street_number));
    $res = $user->Update($update . " street_number = :street_number" . $where, ["street_number" => $street_number]);
}
if (!empty($data->city)) {
    $city = htmlspecialchars(strip_tags($data->city));
    $res = $user->Update($update . " city =:city" . $where, ["city" => $city]);
}
if (!empty($data->state)) {
    $state = htmlspecialchars(strip_tags($data->state));
    $res = $user->Update($update . " state = :state" . $where, ["state" => $state]);
}

if ($res > 0) {
    http_response_code(201);
    $result['user'] =  $user->view($id);
    $result ['result'] = true;
    $result['message']= ' user update successfully ';

} else {
    http_response_code(503);
    $result['Message'] = " User not saved ";
    $result ['result'] = false;
}
echo json_encode($result);
