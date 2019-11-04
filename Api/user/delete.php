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
include('user.php');
$user = new User();
//echo $user->delete($id);
if ($user->delete($id)) {
    http_response_code(204);
    //user data returned successfully
    echo json_encode("user deleted successfully");

}else{
    http_response_code(404);
    echo json_encode(" user not found");
}
