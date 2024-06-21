<?php
require_once '../src/config/database.php';

class UserController
{
    private $connection;
    private $table_name = "users";
    private $table_message = "message";

    public function __construct($databaseConnection )
    {
        $this->connection = $databaseConnection ;
    }

    public function read(){
        $query = "SELECT * FROM " . $this->table_name;
        $queryStatement = $this->connection->prepare($query);
        $queryStatement->execute();

        return $queryStatement;
    }

    public function create($nome, $sobrenome, $email, $telefone, $celular, $cep, $endereco, $cidade, $bairro, $numero, $message) {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, sobrenome=:sobrenome, email=:email, telefone=:telefone, celular=:celular, cep=:cep, endereco=:endereco, cidade=:cidade, bairro=:bairro, numero=:numero";
        $queryStatement = $this->connection->prepare($query);

        $queryStatement->bindParam(':nome', $nome);
        $queryStatement->bindParam(':sobrenome', $sobrenome);
        $queryStatement->bindParam(':email', $email);
        $queryStatement->bindParam(':telefone', $telefone);
        $queryStatement->bindParam(':celular', $celular);
        $queryStatement->bindParam(':cep', $cep);
        $queryStatement->bindParam(':endereco', $endereco);
        $queryStatement->bindParam(':cidade', $cidade);
        $queryStatement->bindParam(':bairro', $bairro);
        $queryStatement->bindParam(':numero', $numero);

        if ($queryStatement ->execute()) {
            $user_id = $this->connection->lastInsertId();
            return $this->createMessage($user_id, $message);
        } else {
            return false;
        }
    }

    private function createMessage($user_id, $message){
        $query = "INSERT INTO " . $this->table_message . " SET user_id=:user_id, message=:message";
        $queryStatement = $this->connection->prepare($query);

        $queryStatement->bindParam(':user_id', $user_id);
        $queryStatement->bindParam(':message', $message);

        return $queryStatement->execute();
    }
}