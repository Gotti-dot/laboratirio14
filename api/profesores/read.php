<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Profesor.php';

$database = new Database();
$db = $database->getConnection();

$profesor = new Profesor($db);

$stmt = $profesor->read();
$num = $stmt->rowCount();

if($num > 0){
    $profesores_arr = array();
    $profesores_arr["profesores"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $profesor_item = array(
            "profesor_id" => $profesor_id,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "especialidad" => $especialidad,
            "telefono" => $telefono,
            "email" => $email,
            "fecha_contratacion" => $fecha_contratacion,
            "activo" => $activo
        );

        array_push($profesores_arr["profesores"], $profesor_item);
    }

    http_response_code(200);
    echo json_encode($profesores_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No se encontraron profesores."));
}
?>
