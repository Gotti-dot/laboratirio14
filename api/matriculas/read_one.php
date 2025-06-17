<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Matriculas.php';

$database = new Database();
$db = $database->getConnection();

$matricula = new Matricula($db);

// Verificar si el ID de la matrícula está presente y válido
$matricula->matricula_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : die(json_encode(array("message" => "ID de matrícula inválido.", "status" => "error")));

$matricula->readOne();

if (!empty($matricula->matricula_id)) {
    // Formatea la respuesta en JSON con los datos de la matrícula
    $matricula_arr = array(
        "matricula_id" => intval($matricula->matricula_id),
        "estudiante_nombre" => $matricula->estudiante_nombre, // Muestra el nombre del estudiante
        "curso_nombre" => $matricula->curso_nombre, // Muestra el nombre del curso
        "fecha_matricula" => $matricula->fecha_matricula,
        "periodo_academico" => htmlspecialchars($matricula->periodo_academico)
    );

    http_response_code(200);
    echo json_encode($matricula_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Matrícula no encontrada.", "status" => "error"));
}
?>
