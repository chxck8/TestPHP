<?php

require_once 'classes/user.class.php';
$_user = new user;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    $listUsers = $_user->listUsers();

    header("Content-Type: application/json");
    echo json_encode($listUsers);
    http_response_code(200);
    

}else if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postData = file_get_contents("php://input");
    $arrayData = $_user->post($postData);

    header('Content-Type: application/json');
    if(isset($arrayData["result"]["error_id"])){
        $response = $arrayData["result"]["error_id"];
        http_response_code($response);
    }else{
        http_response_code(200);
    }
    echo json_encode($arrayData);

}else{

    header('Content-Type: application/json');
    echo 'method not allowed';

    
}


?>