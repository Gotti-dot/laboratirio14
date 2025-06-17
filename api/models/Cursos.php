<?php
class Curso {
    private $conn;
    private $table_name = "Cursos";

    public $curso_id;
    public $nombre;
    public $descripcion;
    public $profesor_id;
    public $horario;
    public $aula;
    public $creditos;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear curso
    function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET nombre=:nombre, descripcion=:descripcion, profesor_id=:profesor_id,
                horario=:horario, aula=:aula, creditos=:creditos";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->profesor_id = htmlspecialchars(strip_tags($this->profesor_id));
        $this->horario = htmlspecialchars(strip_tags($this->horario));
        $this->aula = htmlspecialchars(strip_tags($this->aula));
        $this->creditos = htmlspecialchars(strip_tags($this->creditos));

        // Vincular parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":profesor_id", $this->profesor_id);
        $stmt->bindParam(":horario", $this->horario);
        $stmt->bindParam(":aula", $this->aula);
        $stmt->bindParam(":creditos", $this->creditos);

        return $stmt->execute();
    }

    // Leer todos los cursos
function read() {
    $query = "SELECT curso_id, nombre, descripcion, profesor_id, horario, aula, creditos 
              FROM Cursos 
              ORDER BY nombre";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}



    // Leer un solo curso
function readOne() {
    $query = "SELECT curso_id, nombre, descripcion, profesor_id, horario, aula, creditos
              FROM Cursos
              WHERE curso_id = ? LIMIT 0,1";
              
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->curso_id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row) {
        $this->curso_id = $row['curso_id'];
        $this->nombre = $row['nombre'];
        $this->descripcion = $row['descripcion'];
        $this->profesor_id = $row['profesor_id'];
        $this->horario = $row['horario'];
        $this->aula = $row['aula'];
        $this->creditos = $row['creditos'];
    }
}



    // Actualizar curso
    function update() {
        $query = "UPDATE " . $this->table_name . "
                SET nombre=:nombre, descripcion=:descripcion, profesor_id=:profesor_id,
                horario=:horario, aula=:aula, creditos=:creditos
                WHERE curso_id=:curso_id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->profesor_id = htmlspecialchars(strip_tags($this->profesor_id));
        $this->horario = htmlspecialchars(strip_tags($this->horario));
        $this->aula = htmlspecialchars(strip_tags($this->aula));
        $this->creditos = htmlspecialchars(strip_tags($this->creditos));
        $this->curso_id = htmlspecialchars(strip_tags($this->curso_id));

        // Vincular parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":profesor_id", $this->profesor_id);
        $stmt->bindParam(":horario", $this->horario);
        $stmt->bindParam(":aula", $this->aula);
        $stmt->bindParam(":creditos", $this->creditos);
        $stmt->bindParam(":curso_id", $this->curso_id);

        return $stmt->execute();
    }

    // Eliminar curso
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE curso_id = ?";
        $stmt = $this->conn->prepare($query);
        $this->curso_id = htmlspecialchars(strip_tags($this->curso_id));
        $stmt->bindParam(1, $this->curso_id);
       
        return $stmt->execute();
    }
}
?>
