<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Cursos.php';

$database = new Database();
$db = $database->getConnection();

$curso = new Curso($db);

$stmt = $curso->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $cursos_arr = array();
    $cursos_arr["cursos"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Sanitizar y convertir valores antes de enviarlos en JSON
        $curso_item = array(
            "curso_id" => intval($row["curso_id"]),
            "nombre" => htmlspecialchars($row["nombre"]),
            "descripcion" => htmlspecialchars($row["descripcion"]),
            "profesor_id" => intval($row["profesor_id"]),
            "horario" => htmlspecialchars($row["horario"]),
            "aula" => htmlspecialchars($row["aula"]),
            "creditos" => intval($row["creditos"])
        );

        array_push($cursos_arr["cursos"], $curso_item);
    }

    http_response_code(200);
    echo json_encode($cursos_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No se encontraron cursos.", "status" => "error"));
}
?>
