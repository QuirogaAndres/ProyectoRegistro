<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";

$database = new Database();
$conn = $database->getConnection();

// Leer los datos enviados por el cliente
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nombre) && !empty($data->apellido) && !empty($data->email)) {
    $query = "INSERT INTO estudiantes (nombre, apellido, email) VALUES (:nombre, :apellido, :email)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":nombre", $data->nombre);
    $stmt->bindParam(":apellido", $data->apellido);
    $stmt->bindParam(":email", $data->email);


    if ($stmt->execute()) {
        echo json_encode(["message" => "Estudiante creado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al crear estudiante."]);
    }
} else {
    echo json_encode(["message" => "Datos incompletos."]);
}
?>