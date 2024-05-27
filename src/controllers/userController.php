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

    public function create($nome, $sobrenome, $email, $telefone, $celular, $cep, $endereco, $cidade, $bairro, $numero){
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

        if ($queryStatement->execute()) {
            return true;  // Usuário criado com sucesso
        } else {
            return false; // Falha ao criar usuário
        }
    }
}