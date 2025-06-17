<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Profesor.php';

$database = new Database();
$db = $database->getConnection();

$profesor = new Profesor($db);

$data = json_decode(file_get_contents("php://input"));

$profesor->profesor_id = $data->profesor_id;

if(
    !empty($data->nombre) &&
    !empty($data->apellido) &&
    !empty($data->especialidad) &&
    !empty($data->email)
){
    $profesor->nombre = $data->nombre;
    $profesor->apellido = $data->apellido;
    $profesor->especialidad = $data->especialidad;
    $profesor->telefono = $data->telefono ?? null;
    $profesor->email = $data->email;
    $profesor->activo = isset($data->activo) ? $data->activo : 1;

    if($profesor->update()){
        http_response_code(200);
        echo json_encode(array("message" => "Profesor actualizado correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo actualizar el profesor."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos. No se puede actualizar el profesor."));
}
?>
