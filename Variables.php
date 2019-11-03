<?php
/**
development:
 username: devUsername
  password: $*rs9D(
    production:
username: prodUsername
password: &&KeXt97&sd
**/
$valid_passwords = array ("devUsername" => "$*rs9D(");
$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);
if (!$validated) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Not authorized");
}

$user_name = 'devUsername';
$password = '$*rs9D(';
//SET HEADER
header("Access-Control-Allow-Origin: *");
header("Authorization:Basic". base64_encode("$user_name:$password"));

header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$message['message'] = '';
$errors = [];
$pre_error_msg = ' ! Empty ';
