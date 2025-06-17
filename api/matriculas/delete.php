<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Matriculas.php';

$database = new Database();
$db = $database->getConnection();

$matricula = new Matricula($db);

$data = json_decode(file_get_contents("php://input"));

// Verifica si el ID viene en el objeto data o como parámetro directo
$matricula->matricula_id = isset($data->id) ? intval($data->id) : (isset($data->matricula_id) ? intval($data->matricula_id) : null);

if (!empty($matricula->matricula_id)) {
    if ($matricula->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Matrícula eliminada correctamente.", "status" => "success"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo eliminar la matrícula.", "status" => "error"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No se proporcionó un ID válido para eliminar.", "status" => "error"));
}
?>
