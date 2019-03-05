<?php
// get database connection
include_once '../config/database.php';
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
// set user property values
$user->firstname = 	$_POST['firstname'];
$user->lastname = 	$_POST['lastname'];
$user->email = 		$_POST['email'];
$user->password = 	$_POST['password'];
$user->status = 	$_POST['status'];
$user->company = 	$_POST['company'];
$user->role = 		$_POST['role'];
// create the user
if($user->signup()){
	http_response_code(201);
    $user_arr=array(
        "status" 	=> true,
        "message" 	=> "Successfully Signup!",
        "users_id" 	=> $user->users_id,
        "email" 	=> $user->email,
		"firstname"	=> $user->firstname,
		"lastname"	=> $user->lastname
    );
}
else{
	http_response_code(503);
    $user_arr=array(
        "status" => false,
        "message" => "User email already exists!"
    );
}
print_r(json_encode($user_arr));
?>