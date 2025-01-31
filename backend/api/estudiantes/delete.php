<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";

$database = new Database();
$conn = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $query = "DELETE FROM estudiantes WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $data->id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Estudiante eliminado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al eliminar estudiante."]);
    }
} else {
    echo json_encode(["message" => "Datos incompletos."]);
}
?>
