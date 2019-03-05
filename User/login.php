<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
$database = new Database();
$db = $database->getConnection();

// prepare user object
$user = new User($db);

//$data = json_decode(file_get_contents('php://input'));
$user->email = isset($_GET['username']) ? $_GET['username'] : die();//$user->email = $data->email;
$user->password = isset($_GET['password']) ? $_GET['password'] : die();//$user->password = $data->password;
// read the details of user to be edited
$stmt = $user->login();

if($stmt->rowCount() > 0){
// get retrieved row
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
http_response_code(201);

// create array
$user_arr=array(
"status" => true,
"message" => "Successfully Login!",
"users_id" =>$row['users_id'] ,
"email" =>$user->email,
"firstname"=>$row['firstname'],
"lastname"=>$row['lastname'],
"company"=>$row['company'],
"app_status"=>$row['status'],
"role"=>$row['role']
);
}
else{
http_response_code(503);
$user_arr=array(
"status" => false,
"message" => "Invalid Username or Password!",
);
}
// make it json format
echo json_encode($user_arr);
header('Location: ' . $_SERVER['HTTP_REFERER']);
echo $_SERVER['HTTP_REFERER'];
?>