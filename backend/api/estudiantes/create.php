<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";
require_once "../../models/Estudiante.php";

$database = new Database();
$db = $database->getConnection();
$estudiante = new Estudiante($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nombre) && !empty($data->apellido) && !empty($data->email)) {
    $estudiante->nombre = $data->nombre;
    $estudiante->apellido = $data->apellido;
    $estudiante->email = $data->email;

    if ($estudiante->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Estudiante creado correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear el estudiante."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No se pudo crear el estudiante. Datos incompletos."));
}
?>