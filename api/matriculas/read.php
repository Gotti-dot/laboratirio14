<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Matriculas.php';

$database = new Database();
$db = $database->getConnection();

$matricula = new Matricula($db);

$stmt = $matricula->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $matriculas_arr = array();
    $matriculas_arr["matriculas"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $matricula_item = array(
            "matricula_id" => intval($matricula_id),
            "estudiante_id" => intval($estudiante_id),
            "estudiante_nombre" => "{$estudiante_nombre} {$estudiante_apellido}", // Mostrar nombre
            "curso_id" => intval($curso_id),
            "curso_nombre" => $curso_nombre, // Mostrar nombre del curso
            "fecha_matricula" => $fecha_matricula,
            "periodo_academico" => htmlspecialchars($periodo_academico)
        );

        array_push($matriculas_arr["matriculas"], $matricula_item);
    }

    http_response_code(200);
    echo json_encode($matriculas_arr);
}   else {
    http_response_code(404);
    echo json_encode(array("message" => "No se encontraron matrículas."));
}

?>
