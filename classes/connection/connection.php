<?php

class connection {

    private $dbHost;
    private $dbUser;
    private $dbPassword;
    private $dbName;
    private $dbPort;
    private $dbConnection;

    function __construct(){
        $data = $this->connectionData();
        foreach ($data as $key => $value) {
            $this->dbHost = $value['host'];
            $this->dbUser = $value['user'];
            $this->dbPassword = $value['password'];
            $this->dbName = $value['name'];
            $this->dbPort = $value['port'];
        }
        $this->dbConnection = new mysqli($this->dbHost,$this->dbUser,$this->dbPassword,$this->dbName,$this->dbPort);
        if($this->dbConnection->connect_errno){
            die('Connection Error: ' . $this->connection->connect_errno);
        }

    }

    private function connectionData(){
        $path = dirname(__FILE__);
        $configjson = file_get_contents($path . "/" . "config");
        return json_decode($configjson, true);
    }

    //method for get data
    public function getData($querystr){
        $result = $this->dbConnection->query($querystr);
        $resultArray = array();
        foreach ($result as $key) {
            $resultArray[] = $key;
        }
        return ($resultArray);
    }

    //method for insert, update and delete
    public function nonQuery($querystr){
        $result = $this->dbConnection->query($querystr);
        return $this->dbConnection->affected_rows;
    }


}

?>