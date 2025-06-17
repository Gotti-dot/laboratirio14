<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../models/Estudiante.php';


$database = new Database();
$db = $database->getConnection();


$estudiante = new Estudiante($db);


$data = json_decode(file_get_contents("php://input"));


// Verifica si el ID viene en el objeto data o como parámetro directo
$estudiante->estudiante_id = isset($data->id) ? $data->id : (isset($data->estudiante_id) ? $data->estudiante_id : null);


if(!empty($estudiante->estudiante_id)){
    if($estudiante->delete()){
        http_response_code(200);
        echo json_encode(array("message" => "Estudiante eliminado correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo eliminar el estudiante."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No se proporcionó un ID válido para eliminar."));
}
?>
