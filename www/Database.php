<?php
class Database{

    private $host  = MYSQL_HOST;
    private $user  = MYSQL_USER;
    private $password   = MYSQL_PASSWORD;
    private $database  = MYSQL_DATABASE;

    public function getConnection(){
        $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if($conn->connect_error){
            die("Error failed to connect to MySQL: " . $conn->connect_error);
        } else {
            return $conn;
        }
    }
}