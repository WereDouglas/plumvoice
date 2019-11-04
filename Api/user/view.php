<?php
//The following http codes are possible:
//200 – success, user data returned successfully
//401 – permission denied, invalid http basic credentials
//404 – user not found
//500 – internal server error

include('user.php');
$user = new User();
$u = $user->view($id);

if ($u->first_name!=null) {
    http_response_code(200);
    //user data returned successfully
    echo json_encode($u);

}else{

    http_response_code(404);
    echo json_encode(" user not found");
}
