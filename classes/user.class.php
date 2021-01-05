<?php
require_once "connection/connection.php";
require_once 'classes/connection/connection.php';

class user {

    protected $myUsername = "";
    protected $myPassword = "";
    protected $username = "";
    protected $password = "";
    protected $lastAccess = "0000-00-00 00:00:00";
    protected $userType = "";
    protected $status = "";

    public function listUsers(){

        $connect = new connection;
        $query = "SELECT UserId, Username, LastAccess, UserType, Status FROM users";
        $data = $connect->getData($query);
        return ($data);
    }

    public function post($json){

        $data = json_decode($json,true);

        if(!isset($data['myUsername']) || !isset($data['myPassword']) || !isset($data['username']) || !isset($data['password']) || !isset($data['userType']) || !isset($data['status'])){
            echo 'bad request';
        }else{
            $this->myUsername = $data['myUsername'];
            $this->myPassword = md5($data['myPassword']);
            $this->username = $data['username'];
            $this->password = md5($data['password']);
            $this->userType = $data['userType'];
            $this->status = $data['status'];

            $this->addUser();
        }

        }
      

    private function addUser(){
        $_connect = new connection;
        $query = "INSERT INTO users (Username,Password,LastAccess,UserType, Status) VALUES('$this->username','$this->password','$this->lastAccess','$this->userType','$this->status')";
        $insertUser = $_connect->nonQuery($query);
        if($insertUser){
             echo 'created';
        }else{
            echo 'internal server error';
        }
    }




}
?>