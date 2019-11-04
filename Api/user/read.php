<?php

include('User.php');
$user = new User();
$users = $user->records();
if (count($users) > 0) {
    http_response_code(200);
    echo json_encode($users);
}else{

    http_response_code(404);
    echo json_encode(["message"=>"User records"]);
}
