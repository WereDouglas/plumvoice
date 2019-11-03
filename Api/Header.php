<?php

/**
 * development:
 * username: devUsername
 * password: $*rs9D(
 * production:
 * username: prodUsername
 * password: &&KeXt97&sd
 **/
$valid_passwords = array("devUsername" => "$*rs9D(");
$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);
if (!$validated) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401  permission denied, invalid http basic credentials');
    die ("Not authorized");
}

?>