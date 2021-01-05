<?php
require_once 'classes/connection/connection.php';

class auth {

    public function auth($json){

        $inputData = json_decode($json,true);

        //if input data has errors
        if(!isset($inputData['user']) || !isset($inputData['password'])) {
            echo 'bad request';
        
        }else{

            $user = $inputData['user'];
            $password = $inputData['password'];
            $passwordEncrypted = md5($password);
            //get user data
            $userData = $this-> getUserData($user);
            if ($userData){

                //if user password is correct then add token
                if ($userData[0]["Password"] == $passwordEncrypted){
                    $this->addToken($userData[0]["UserId"]);
                }else{
                    echo 'invalid password';
                }
                
            }else{
                echo 'invalid user';
            }
            
        }
    }
    
    private function getUserData($user){
        $connect = new connection;
        $query = "SELECT UserId, Username, Password, LastAccess, UserType, Status FROM users WHERE Username = '$user'";        
        //use connection class method to get user data
        $userData = $connect->getData($query);
        if (isset($userData['UserId'])){
            return 'user not found';
        }else{
            return $userData;
        }
    }

    private function addToken($userID){
        $connect = new connection;
        $true = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$true));
        $date = date("Y-m-d H:i");
        $status = "Active";
        $query = "INSERT INTO users_tokens (UserId,Token,Status,Date) VALUES('$userID','$token','$status','$date')";
        
        //use connection class method to insert token data
        $insertToken = $connect->nonQuery($query);
        if ($insertToken){
            echo $token;
        }else{
            echo 'token not created';
        }
    }
}

?>