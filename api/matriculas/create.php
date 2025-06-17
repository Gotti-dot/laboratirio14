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

if(
    !empty($data->estudiante_id) &&
    !empty($data->curso_id) &&
    !empty($data->periodo_academico)
){
    // Asignar datos
    $matricula->estudiante_id = intval($data->estudiante_id);
    $matricula->curso_id = intval($data->curso_id);
    $matricula->periodo_academico = htmlspecialchars(strip_tags($data->periodo_academico));
    $matricula->fecha_matricula = date("Y-m-d");

    if ($matricula->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Matrícula creada correctamente.", "status" => "success"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear la matrícula.", "status" => "error"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos. No se puede crear la matrícula.", "status" => "error"));
}
?>
