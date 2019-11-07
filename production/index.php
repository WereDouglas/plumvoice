<?php
/**
 * development:
 * user_name: devUsername
 * password: $*rs9D(
 * production:
 * user_name: prodUsername
 * password: &&KeXt97&sd
 **/
// show error reporting
//error_reporting(0);
$valid_passwords = array("prodUsername" => "&&KeXt97&sd");
$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);
if (!$validated) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401  permission denied, invalid http basic credentials');
    die ("permission denied, invalid http basic credentials");
}

$message['message'] = '';
$errors = [];
$pre_error_msg = ' ! Empty ';

function parse_path()
{
    $path = array();
    if (isset($_SERVER['REQUEST_URI'])) {
        $request_path = explode('?', $_SERVER['REQUEST_URI']);

        $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
        /** @var TYPE_NAME $request_path */
        $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
        $path['call'] = utf8_decode($path['call_utf8']);
        if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
            $path['call'] = '';
        }
        $path['call_parts'] = explode('/', $path['call']);
    }
    return $path;
}

$path_info = parse_path();
$directory = $path_info['call_parts'][1];
$parameter = $path_info['call_parts'][2];
//include ('Header.php');
if (!empty($directory) && empty($parameter)) {
//redirect to index /list users
//echo 'DIR:'.$directory.' (we want to create )';
    include("user/create.php");
    exit;
}
if (!empty($directory) && $parameter == "list") {
    include("user/read.php");
    exit;
}
if (!empty($directory) && !empty($parameter)) {
    //directory not empty and parameter not empty hence its a GET call
    //'DIR:'.$directory.' PARAM: '.$parameter.' ( { get} based on the parameter) ';
    $id =htmlspecialchars(strip_tags($parameter));
    if( $_SERVER['REQUEST_METHOD']==='GET') {
         include("user/view.php");
    } if( $_SERVER['REQUEST_METHOD']==='DELETE') {
        include("user/delete.php");    }
    if( $_SERVER['REQUEST_METHOD']==='PUT') {
        include("user/update.php");
    }
    exit;
}