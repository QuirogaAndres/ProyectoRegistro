<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";
require_once "../../models/Docente.php";

$database = new Database();
$db = $database->getConnection();
$docente = new Docente($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nombre) && !empty($data->apellido) && !empty($data->email) && !empty($data->departamento)){
    $docente->nombre = $data->nombre;
    $docente->apellido = $data->apellido;
    $docente->email = $data->email;
    $docente->departamento = $data->departamento;

    if ($docente->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Docente creado correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear el docente."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No se pudo crear el docente. Datos incompletos."));
}
?>