<?php
class Estudiante {
    private $conn;
    private $table_name = "estudiantes";

    public $id;
    public $nombre;
    public $apellido;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Crear estudiante
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, apellido, email) VALUES (:nombre, :apellido, :email)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":email", $this->email);

        return $stmt->execute();
    }

    // Leer todos los estudiantes
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar estudiante
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre, apellido=:apellido, email=:email WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":email", $this->email);

        return $stmt->execute();
    }

    // Eliminar estudiante
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}
?>