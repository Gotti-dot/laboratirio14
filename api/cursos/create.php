<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Cursos.php';

$database = new Database();
$db = $database->getConnection();

$curso = new Curso($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->nombre) &&
    !empty($data->descripcion) &&
    !empty($data->profesor_id) &&
    !empty($data->horario) &&
    !empty($data->aula) &&
    !empty($data->creditos)
){
    // Sanitizar datos
    $curso->nombre = htmlspecialchars(strip_tags($data->nombre));
    $curso->descripcion = htmlspecialchars(strip_tags($data->descripcion));
    $curso->profesor_id = htmlspecialchars(strip_tags($data->profesor_id));
    $curso->horario = htmlspecialchars(strip_tags($data->horario));
    $curso->aula = htmlspecialchars(strip_tags($data->aula));
    $curso->creditos = htmlspecialchars(strip_tags($data->creditos));

    if($curso->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Curso creado correctamente.", "status" => "success"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear el curso.", "status" => "error"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos. No se puede crear el curso.", "status" => "error"));
}
?>
