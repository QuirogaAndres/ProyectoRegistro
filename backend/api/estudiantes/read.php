<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";
require_once "../../models/Estudiante.php";

$database = new Database();
$db = $database->getConnection();
$estudiante = new Estudiante($db);

$stmt = $estudiante->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $estudiantes_arr = array();
    $estudiantes_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $estudiante_item = array(
            "id" => $id,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "email" => $email
        );
        array_push($estudiantes_arr["records"], $estudiante_item);
    }
    http_response_code(200);
    echo json_encode($estudiantes_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No se encontraron estudiantes."));
}
