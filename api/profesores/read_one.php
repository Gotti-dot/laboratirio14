<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Profesor.php';

$database = new Database();
$db = $database->getConnection();

$profesor = new Profesor($db);

// Obtiene el ID del profesor desde la URL
$profesor->profesor_id = isset($_GET['id']) ? $_GET['id'] : die();

// Ejecuta la función para leer un solo profesor
$profesor->readOne();
error_log("Profesor activo: " . $profesor->activo);


if($profesor->nombre != null){
    // Formatea la respuesta en JSON con los datos del profesor
    $profesor_arr = array(
        "profesor_id" => $profesor->profesor_id,
        "nombre" => $profesor->nombre,
        "apellido" => $profesor->apellido,
        "especialidad" => $profesor->especialidad,
        "telefono" => $profesor->telefono,
        "email" => $profesor->email,
        "fecha_contratacion" => $profesor->fecha_contratacion,
        "activo" => $profesor->activo
    );

    http_response_code(200);
    echo json_encode($profesor_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Profesor no encontrado."));
}
?>
