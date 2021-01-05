<?php
require_once "connection/connection.php";
require_once 'classes/connection/connection.php';

class user {

    protected $userId = "";    
    protected $user = "";
    protected $pass = "";
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

        if(!isset($data['user']) || !isset($data['pass']) || !isset($data['username']) || !isset($data['password']) || !isset($data['userType']) || !isset($data['status'])){
            echo 'bad request';
        }else{
            $this->user = $data['user'];
            $this->pass = md5($data['pass']);
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

    
    public function put($json){

        $data = json_decode($json,true);

        //get the entire user data if doesn't edit all fields, so in that way we don't loss user data
        $conn = new connection;
        $userQuery = "SELECT Username, Password, LastAccess, UserType, Status FROM users  WHERE UserId = '" . $data['userId'] . "'";
        $userData = $conn->getData($userQuery);

        //storing current user data
        $this->username = $userData[0]['Username'];
        $this->password = $userData[0]['Password'];
        $this->userType = $userData[0]['UserType'];
        $this->status = $userData[0]['Status'];
        
        //storing new user data
        $this->userId = $data['userId'];
        if(isset($data['username'])) { $this->username = $data['username']; }
        if(isset($data['password'])) { $this->password = md5($data['password']); }
        if(isset($data['userType'])) { $this->userType = $data['userType']; }
        if(isset($data['status'])) { $this->status = $data['status']; }

        $this->editUser();

}

    private function editUser(){
        $_connect = new connection;
        $query = "UPDATE users SET Username ='" . $this->username . "', Password = '" . $this->password . "', UserType = '" . $this->userType . "', Status = '" .
        $this->status ."' WHERE UserId = '" . $this->userId . "'"; 
        $editUser = $_connect->nonQuery($query);
        if($editUser >= 1){
            echo 'accepted';
        }else{
            echo 'internal server error';
        }
    }

public function delete($json){

    $data = json_decode($json,true);

    if(!isset($data['userId'])){
        echo 'error 400';
    }else{
        $this->userId = $data['userId'];
        $this->deleteUser();
        }

    }

    private function deleteUser(){
        $_connect = new connection;
        $query = "DELETE FROM users WHERE UserId= '" . $this->userId . "'";
        $deleteUser = $_connect->nonQuery($query);
        if($deleteUser >= 1 ){
            echo 'accepted';
        }else{
            echo 'internal server error';
        }
    }


}

?>