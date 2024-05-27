<?php
class Database{
    private $database = "api_php";
    private $host = "localhost";
    private $user = "root";
    private $password = "36217900";
    public $connection;

    public function getConnection(){
        $this->connection = null;
        try{
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->user, $this->password);
            $this->connection->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->connection;
    }
}