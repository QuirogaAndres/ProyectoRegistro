<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";
require_once "../../models/Docente.php";

$database = new Database();
$db = $database->getConnection();
$docente = new Docente($db);

$stmt = $docente->read();
$stmt->execute();
$num = $stmt->rowCount();

if ($num > 0) {
    $docentes_arr = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $docentes_arr[] = $row;
    }

    echo json_encode($docentes_arr);
} else {
    echo json_encode(["message" => "No hay docentes registrados."]);
}
?>
