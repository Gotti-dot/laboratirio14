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

if(
    !empty($data->nombre) &&
    !empty($data->apellido) &&
    !empty($data->especialidad) &&
    !empty($data->email)
){
    $profesor->nombre = htmlspecialchars(strip_tags($data->nombre));
    $profesor->apellido = htmlspecialchars(strip_tags($data->apellido));
    $profesor->especialidad = htmlspecialchars(strip_tags($data->especialidad));
    $profesor->telefono = !empty($data->telefono) ? htmlspecialchars(strip_tags($data->telefono)) : null;
    $profesor->email = htmlspecialchars(strip_tags($data->email));
    $profesor->fecha_contratacion = date("Y-m-d");
    $profesor->activo = isset($data->activo) ? $data->activo : 1; // Estado activo por defecto

    if($profesor->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Profesor creado correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear el profesor."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos. No se puede crear el profesor."));
}
?>
