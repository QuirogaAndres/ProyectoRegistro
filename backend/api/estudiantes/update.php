<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";
require_once "../../models/Estudiante.php";

$database = new Database();
$db = $database->getConnection();
$estudiante = new Estudiante($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $estudiante->id = $data->id;
    $estudiante->nombre = $data->nombre ?? null;
    $estudiante->apellido = $data->apellido ?? null;
    $estudiante->email = $data->email ?? null;

    if ($estudiante->update()) {
        echo json_encode(["message" => "Estudiante actualizado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al actualizar estudiante."]);
    }
} else {
    echo json_encode(["message" => "ID no proporcionado."]);
}