<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/database.php';
include_once '../models/Estudiante.php';


$database = new Database();
$db = $database->getConnection();


$estudiante = new Estudiante($db);


$estudiante->estudiante_id = isset($_GET['id']) ? $_GET['id'] : die();


$estudiante->readOne();


if($estudiante->nombre != null){
    $estudiante_arr = array(
        "estudiante_id" => $estudiante->estudiante_id,
        "nombre" => $estudiante->nombre,
        "apellido" => $estudiante->apellido,
        "fecha_nacimiento" => $estudiante->fecha_nacimiento,
        "genero" => $estudiante->genero,
        "direccion" => $estudiante->direccion,
        "telefono" => $estudiante->telefono,
        "email" => $estudiante->email,
        "fecha_ingreso" => $estudiante->fecha_ingreso
    );


    http_response_code(200);
    echo json_encode($estudiante_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Estudiante no encontrado."));
}
?>
