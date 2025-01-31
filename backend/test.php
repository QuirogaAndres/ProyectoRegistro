<?php
require_once "config/database.php";

$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "No se pudo conectar a la base de datos.";
}
?>
<?php
echo "Conexión exitosa a docentes.";
?>
<?php
echo "Conexión exitosa a estudiantes.";
?>