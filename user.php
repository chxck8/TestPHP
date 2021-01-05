<?php

require_once 'classes/user.class.php';
$_user = new user;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    $listUsers = $_user->listUsers();
    header("Content-Type: application/json");
    echo json_encode($listUsers);
    http_response_code(200);
    
}else{

    header('Content-Type: application/json');
    echo 'method not allowed';

}


?>