<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Matriculas.php';

$database = new Database();
$db = $database->getConnection();

$matricula = new Matricula($db);

$data = json_decode(file_get_contents("php://input"));

$matricula->matricula_id = isset($data->matricula_id) ? intval($data->matricula_id) : null;

if(
    !empty($matricula->matricula_id) &&
    !empty($data->estudiante_id) &&
    !empty($data->curso_id) &&
    !empty($data->periodo_academico)
){
    // Asignar datos
    $matricula->estudiante_id = intval($data->estudiante_id);
    $matricula->curso_id = intval($data->curso_id);
    $matricula->periodo_academico = htmlspecialchars(strip_tags($data->periodo_academico));

    if ($matricula->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Matrícula actualizada correctamente.", "status" => "success"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo actualizar la matrícula.", "status" => "error"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos. No se puede actualizar la matrícula.", "status" => "error"));
}
?>
