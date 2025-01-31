<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";

$database = new Database();
$conn = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

// Validar que el ID está presente
if (!empty($data->id)) {
    // Construcción dinámica de la consulta
    $fieldsToUpdate = [];
    $params = [];

    if (!empty($data->nombre)) {
        $fieldsToUpdate[] = "nombre = :nombre";
        $params[':nombre'] = $data->nombre;
    }
    if (!empty($data->apellido)) {
        $fieldsToUpdate[] = "apellido = :apellido";
        $params[':apellido'] = $data->apellido;
    }
    if (!empty($data->email)) {
        $fieldsToUpdate[] = "email = :email";
        $params[':email'] = $data->email;
    }
    if (!empty($data->departamento)) {
        $fieldsToUpdate[] = "departamento = :departamento";
        $params[':departamento'] = $data->departamento;
    }

    // Si no hay campos para actualizar, devolver error
    if (empty($fieldsToUpdate)) {
        echo json_encode(["message" => "No se proporcionaron datos para actualizar."]);
        exit();
    }

    // Construir la consulta de actualización
    $query = "UPDATE docentes SET " . implode(", ", $fieldsToUpdate) . " WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);

    // Bind dinámico de parámetros
    foreach ($params as $param => $value) {
        $stmt->bindParam($param, $value);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["message" => "Docente actualizado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al actualizar docente."]);
    }
} else {
    echo json_encode(["message" => "ID no proporcionado."]);
}
?>
