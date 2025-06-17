<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Cursos.php';

$database = new Database();
$db = $database->getConnection();

$curso = new Curso($db);

// Verificar si el ID del curso está presente y válido
$curso->curso_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : die(json_encode(array("message" => "ID de curso inválido.", "status" => "error")));

// Ejecuta la función para leer un solo curso
$curso->readOne();

if (!empty($curso->nombre)) {
    // Formatea la respuesta en JSON con los datos del curso y el profesor asignado
    $curso_arr = array(
        "curso_id" => intval($curso->curso_id),
        "nombre" => htmlspecialchars($curso->nombre),
        "descripcion" => htmlspecialchars($curso->descripcion),
        "profesor_id" => intval($curso->profesor_id),
        "horario" => htmlspecialchars($curso->horario),
        "aula" => htmlspecialchars($curso->aula),
        "creditos" => intval($curso->creditos)
    );

    http_response_code(200);
    echo json_encode($curso_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Curso no encontrado.", "status" => "error"));
}
?>
