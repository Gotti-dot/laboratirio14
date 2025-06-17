<?php
class Estudiante {
    private $conn;
    private $table_name = "Estudiantes";


    public $estudiante_id;
    public $nombre;
    public $apellido;
    public $fecha_nacimiento;
    public $genero;
    public $direccion;
    public $telefono;
    public $email;
    public $fecha_ingreso;
    public $activo;


    public function __construct($db) {
        $this->conn = $db;
    }


    // Crear estudiante
    function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET nombre=:nombre, apellido=:apellido, fecha_nacimiento=:fecha_nacimiento,
                genero=:genero, direccion=:direccion, telefono=:telefono, email=:email,
                fecha_ingreso=CURDATE(), activo=1";


        $stmt = $this->conn->prepare($query);


        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));
        $this->genero = htmlspecialchars(strip_tags($this->genero));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email = htmlspecialchars(strip_tags($this->email));


        // Vincular parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);


        if($stmt->execute()) {
            return true;
        }
        return false;
    }


    // Leer todos los estudiantes
    function read() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE activo = 1 ORDER BY apellido, nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    // Leer un solo estudiante
    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE estudiante_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->estudiante_id);
        $stmt->execute();
       
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
        if($row) {
            $this->nombre = $row['nombre'];
            $this->apellido = $row['apellido'];
            $this->fecha_nacimiento = $row['fecha_nacimiento'];
            $this->genero = $row['genero'];
            $this->direccion = $row['direccion'];
            $this->telefono = $row['telefono'];
            $this->email = $row['email'];
            $this->fecha_ingreso = $row['fecha_ingreso'];
        }
    }


    // Actualizar estudiante
    function update() {
        $query = "UPDATE " . $this->table_name . "
                SET nombre=:nombre, apellido=:apellido, fecha_nacimiento=:fecha_nacimiento,
                genero=:genero, direccion=:direccion, telefono=:telefono, email=:email
                WHERE estudiante_id=:estudiante_id";


        $stmt = $this->conn->prepare($query);


        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));
        $this->genero = htmlspecialchars(strip_tags($this->genero));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->estudiante_id = htmlspecialchars(strip_tags($this->estudiante_id));


        // Vincular parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":estudiante_id", $this->estudiante_id);


        if($stmt->execute()) {
            return true;
        }
        return false;
    }


    // Eliminar estudiante (soft delete)
    function delete() {
        //$query = "UPDATE " . $this->table_name . " SET activo = 0 WHERE estudiante_id = ?";
        $query = "DELETE FROM " . $this->table_name . " WHERE estudiante_id = ?";
        $stmt = $this->conn->prepare($query);
        $this->estudiante_id = htmlspecialchars(strip_tags($this->estudiante_id));
        $stmt->bindParam(1, $this->estudiante_id);
       
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
