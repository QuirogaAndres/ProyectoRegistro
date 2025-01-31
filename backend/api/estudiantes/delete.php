<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";
require_once "../../models/Estudiante.php";

$database = new Database();
$db = $database->getConnection();
$estudiante = new Estudiante($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $estudiante->id = $data->id;

    if ($estudiante->delete()) {
        echo json_encode(["message" => "Estudiante eliminado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al eliminar estudiante."]);
    }
} else {
    echo json_encode(["message" => "ID no proporcionado."]);
}