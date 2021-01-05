<?php
require_once "connection/connection.php";

class user {

    public function listUsers(){

        $connect = new connection;
        $query = "SELECT UserId, Username,LastAccess, UserType, Status FROM users";
        $data = $connect->getData($query);
        return ($data);
    }
}
?>