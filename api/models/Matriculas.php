<?php
class Matricula {
    private $conn;
    private $table_name = "matriculas";

    public $matricula_id;
    public $estudiante_id;
    public $curso_id;
    public $fecha_matricula;
    public $periodo_academico;
    public $estudiante_nombre;
    public $curso_nombre;


    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear matrícula
    function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET estudiante_id=:estudiante_id, curso_id=:curso_id, fecha_matricula=CURDATE(), periodo_academico=:periodo_academico";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->estudiante_id = htmlspecialchars(strip_tags($this->estudiante_id));
        $this->curso_id = htmlspecialchars(strip_tags($this->curso_id));
        $this->periodo_academico = htmlspecialchars(strip_tags($this->periodo_academico));

        // Vincular parámetros
        $stmt->bindParam(":estudiante_id", $this->estudiante_id);
        $stmt->bindParam(":curso_id", $this->curso_id);
        $stmt->bindParam(":periodo_academico", $this->periodo_academico);

        return $stmt->execute();
    }

    // Leer todas las matrículas
function read() {
    $query = "SELECT m.matricula_id, m.fecha_matricula, m.periodo_academico, 
                     e.estudiante_id, e.nombre AS estudiante_nombre, e.apellido AS estudiante_apellido,
                     c.curso_id, c.nombre AS curso_nombre
              FROM matriculas m
              LEFT JOIN estudiantes e ON m.estudiante_id = e.estudiante_id
              LEFT JOIN cursos c ON m.curso_id = c.curso_id
              ORDER BY m.fecha_matricula DESC";
              
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}



    // Leer una sola matrícula
function readOne() {
    $query = "SELECT m.matricula_id, m.fecha_matricula, m.periodo_academico, 
                     e.nombre AS estudiante_nombre, e.apellido AS estudiante_apellido,
                     c.nombre AS curso_nombre
              FROM matriculas m
              LEFT JOIN estudiantes e ON m.estudiante_id = e.estudiante_id
              LEFT JOIN cursos c ON m.curso_id = c.curso_id
              WHERE m.matricula_id = ? LIMIT 0,1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->matricula_id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $this->matricula_id = $row['matricula_id'];
        $this->fecha_matricula = $row['fecha_matricula'];
        $this->periodo_academico = $row['periodo_academico'];
        $this->estudiante_nombre = "{$row['estudiante_nombre']} {$row['estudiante_apellido']}";
        $this->curso_nombre = $row['curso_nombre'];
    }
}




    // Actualizar matrícula
function update() {
    $query = "UPDATE matriculas 
              SET estudiante_id=:estudiante_id, curso_id=:curso_id, periodo_academico=:periodo_academico 
              WHERE matricula_id=:matricula_id";

    $stmt = $this->conn->prepare($query);

    // Sanitizar datos
    $this->estudiante_id = intval($this->estudiante_id);
    $this->curso_id = intval($this->curso_id);
    $this->periodo_academico = htmlspecialchars(strip_tags($this->periodo_academico));
    $this->matricula_id = intval($this->matricula_id);

    // Vincular parámetros
    $stmt->bindParam(":estudiante_id", $this->estudiante_id);
    $stmt->bindParam(":curso_id", $this->curso_id);
    $stmt->bindParam(":periodo_academico", $this->periodo_academico);
    $stmt->bindParam(":matricula_id", $this->matricula_id);

    return $stmt->execute();
}


    // Eliminar matrícula
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE matricula_id = ?";
        $stmt = $this->conn->prepare($query);
        $this->matricula_id = htmlspecialchars(strip_tags($this->matricula_id));
        $stmt->bindParam(1, $this->matricula_id);

        return $stmt->execute();
    }
}
?>
