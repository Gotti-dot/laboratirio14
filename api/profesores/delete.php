<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Profesor.php';

$database = new Database();
$db = $database->getConnection();

$profesor = new Profesor($db);

$data = json_decode(file_get_contents("php://input"));

// Verifica si el ID viene en el objeto data o como parámetro directo
$profesor->profesor_id = isset($data->id) ? $data->id : (isset($data->profesor_id) ? $data->profesor_id : null);

if(!empty($profesor->profesor_id)){
    if($profesor->delete()){
        http_response_code(200);
        echo json_encode(array("message" => "Profesor eliminado correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo eliminar el profesor."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No se proporcionó un ID válido para eliminar."));
}
?>
