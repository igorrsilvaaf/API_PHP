<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../src/controllers/userController.php';
require_once '../src/config/database.php';

$database = new Database();
$databaseConnection = $database->getConnection();
$userController = new UserController($databaseConnection);
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        $queryStatement  = $userController->read();
        $num = $queryStatement ->rowCount();
        if ($num > 0){
            $user_arr = array();
            $user_arr["records"] = array();

            while($row = $queryStatement->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                $user_item = array(
                    "id" => $id,
                    "nome" => $nome,
                    "sobrenome" => $sobrenome,
                    "email" => $email,
                    "telefone" => $telefone,
                    "celular" => $celular,
                    "cep" => $cep,
                    "endereco" => $endereco,
                    "cidade" => $cidade,
                    "bairro" => $bairro,
                    "numero" => $numero
                );

                array_push($user_arr["records"], $user_item);
            }

            http_response_code(200);
            echo json_encode($user_arr);
        }else{
            http_response_code(404);
            echo json_encode(array("message" => "No user found"));
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method Not Allowed"));
        break;
}