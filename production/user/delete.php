<?php
//HTTP Method: DELETE
//The following http codes are possible:
//204 – user deleted successfully
//401 – permission denied, invalid http basic credentials
//TODO 404 – user not found
//500 – internal server error
//The response body will be an application/json object (or empty) and the member variables will vary
//depending on the http code returned.
//For non-204 http codes (unsuccessful):
//error – string indicating the error
//For 204 http codes (success):
//    no body
include('model/user.php');
$user = new User();
$old_user = $user->view($id);
if ($user->delete($id)) {

    $deleted_user = $user->view($id);
    // $result['message']= ' user deleted successfully';
    if ($deleted_user->user_id == null && $old_user->user_id == null) {
        http_response_code(404);
        $result['message'] = ' user does not exist ';
        $result['user'] = null;
        $result ['result'] = false;
    } else {
        if ($deleted_user->user_id == null && $old_user->user_id != null) {
            http_response_code(404);
            $result['user'] = $old_user;
            $result ['result'] = true;
            $result['message'] = ' user deleted successfully ';
        }
    }
    //http_response_code(204);
} else {
    http_response_code(404);
    $result['user'] = $old_user;
    $result['message'] = ' user not found';
}
echo json_encode($result);
