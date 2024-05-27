<?php
require_once '../src/config/database.php';

class UserController
{
    private $connection;
    private $table_name = "users";

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

    public function create($nome, $email) {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email";
        $queryStatement = $this->connection->prepare($query);

        $queryStatement->bindParam(':nome', $nome);
        $queryStatement->bindParam(':email', $email);

        if ($queryStatement->execute()) {
            return true;  // Usuário criado com sucesso
        } else {
            return false; // Falha ao criar usuário
        }
    }
}