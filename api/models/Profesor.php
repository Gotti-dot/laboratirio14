<?php
class Profesor {
    private $conn;
    private $table_name = "Profesores";

    public $profesor_id;
    public $nombre;
    public $apellido;
    public $especialidad;
    public $telefono;
    public $email;
    public $fecha_contratacion;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear profesor
    function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET nombre=:nombre, apellido=:apellido, especialidad=:especialidad,
                telefono=:telefono, email=:email, fecha_contratacion=CURDATE(), activo=:activo";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->especialidad = htmlspecialchars(strip_tags($this->especialidad));
        $this->telefono = !empty($this->telefono) ? htmlspecialchars(strip_tags($this->telefono)) : null;
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->activo = isset($this->activo) ? intval($this->activo) : 1; // Estado por defecto

        // Vincular parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":especialidad", $this->especialidad);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":activo", $this->activo);

        return $stmt->execute();
    }

    // Leer todos los profesores
    function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY apellido, nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer un solo profesor
    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE profesor_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->profesor_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->nombre = $row['nombre'];
            $this->apellido = $row['apellido'];
            $this->especialidad = $row['especialidad'];
            $this->telefono = $row['telefono'];
            $this->email = $row['email'];
            $this->fecha_contratacion = $row['fecha_contratacion'];
            $this->activo = $row['activo']; // Corrección
        }
    }

    // Actualizar profesor
    function update() {
        $query = "UPDATE " . $this->table_name . "
                SET nombre=:nombre, apellido=:apellido, especialidad=:especialidad,
                telefono=:telefono, email=:email, activo=:activo
                WHERE profesor_id=:profesor_id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->especialidad = htmlspecialchars(strip_tags($this->especialidad));
        $this->telefono = !empty($this->telefono) ? htmlspecialchars(strip_tags($this->telefono)) : null;
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->activo = isset($this->activo) ? intval($this->activo) : 1;
        $this->profesor_id = htmlspecialchars(strip_tags($this->profesor_id));

        // Vincular parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":especialidad", $this->especialidad);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":activo", $this->activo);
        $stmt->bindParam(":profesor_id", $this->profesor_id);

        return $stmt->execute();
    }

    // Eliminar profesor
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE profesor_id = ?";
        $stmt = $this->conn->prepare($query);
        $this->profesor_id = htmlspecialchars(strip_tags($this->profesor_id));
        $stmt->bindParam(1, $this->profesor_id);
       
        return $stmt->execute();
    }
}
?>
