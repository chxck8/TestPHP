<?php

require_once 'classes/auth.class.php';

$_auth = new auth;

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $postData = file_get_contents('php://input');
    $arrayData = $_login->auth($postData);

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