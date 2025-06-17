<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Cursos.php';

$database = new Database();
$db = $database->getConnection();

$curso = new Curso($db);

// Obtener los datos enviados en la solicitud
$data = json_decode(file_get_contents("php://input"));

// Validar que `curso_id` esté presente
if (!empty($data->curso_id)) {
    $curso->curso_id = htmlspecialchars(strip_tags($data->curso_id));

    if ($curso->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Curso eliminado correctamente.", "status" => "success"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo eliminar el curso.", "status" => "error"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID de curso faltante. No se puede eliminar.", "status" => "error"));
}
?>
