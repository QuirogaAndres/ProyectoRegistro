<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";
require_once "../../models/Docente.php";

$database = new Database();
$db = $database->getConnection();
$docente = new Docente($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $docente->id = $data->id;
    $docente->nombre = $data->nombre ?? null;
    $docente->apellido = $data->apellido ?? null;
    $docente->email = $data->email ?? null;
    $docente->departamento = $data->departamento ?? null;

    if ($docente->update()) {
        echo json_encode(["message" => "Docente actualizado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al actualizar docente."]);
    }
} else {
    echo json_encode(["message" => "ID no proporcionado."]);
}
?>  