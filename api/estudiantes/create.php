<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../models/Estudiante.php';


$database = new Database();
$db = $database->getConnection();


$estudiante = new Estudiante($db);


$data = json_decode(file_get_contents("php://input"));


if(
    !empty($data->nombre) &&
    !empty($data->apellido) &&
    !empty($data->fecha_nacimiento) &&
    !empty($data->email)
){
    $estudiante->nombre = $data->nombre;
    $estudiante->apellido = $data->apellido;
    $estudiante->fecha_nacimiento = $data->fecha_nacimiento;
    $estudiante->genero = $data->genero ?? null;
    $estudiante->direccion = $data->direccion ?? null;
    $estudiante->telefono = $data->telefono ?? null;
    $estudiante->email = $data->email;


    if($estudiante->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Estudiante creado correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear el estudiante."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos. No se puede crear el estudiante."));
}
?>
