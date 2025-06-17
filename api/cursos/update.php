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

$curso->curso_id = isset($data->curso_id) ? intval($data->curso_id) : die(json_encode(array("message" => "ID de curso inválido.", "status" => "error")));

if(
    !empty($data->nombre) &&
    !empty($data->descripcion) &&
    !empty($data->profesor_id) &&
    !empty($data->horario) &&
    !empty($data->aula) &&
    !empty($data->creditos)
){
    // Sanitización de datos
    $curso->nombre = htmlspecialchars(strip_tags($data->nombre));
    $curso->descripcion = htmlspecialchars(strip_tags($data->descripcion));
    $curso->profesor_id = intval($data->profesor_id);
    $curso->horario = htmlspecialchars(strip_tags($data->horario));
    $curso->aula = htmlspecialchars(strip_tags($data->aula));
    $curso->creditos = intval($data->creditos);

    if($curso->update()){
        http_response_code(200);
        echo json_encode(array("message" => "Curso actualizado correctamente.", "status" => "success"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo actualizar el curso.", "status" => "error"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos. No se puede actualizar el curso.", "status" => "error"));
}
?>
