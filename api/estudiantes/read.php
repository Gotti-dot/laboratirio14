<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/database.php';
include_once '../models/Estudiante.php';


$database = new Database();
$db = $database->getConnection();


$estudiante = new Estudiante($db);


$stmt = $estudiante->read();
$num = $stmt->rowCount();


if($num > 0){
    $estudiantes_arr = array();
    $estudiantes_arr["estudiantes"] = array();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);


        $estudiante_item = array(
            "estudiante_id" => $estudiante_id,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "fecha_nacimiento" => $fecha_nacimiento,
            "genero" => $genero,
            "direccion" => $direccion,
            "telefono" => $telefono,
            "email" => $email,
            "fecha_ingreso" => $fecha_ingreso
        );


        array_push($estudiantes_arr["estudiantes"], $estudiante_item);
    }


    http_response_code(200);
    echo json_encode($estudiantes_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No se encontraron estudiantes."));
}
?>
