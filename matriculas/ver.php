<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}
include_once '../includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Detalles de la Matrícula</h2>

    <div class="card">
        <div class="card-body" id="detalles-matricula">
            <!-- Los datos se cargarán con JavaScript -->
        </div>
    </div>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const id = <?php echo $id; ?>;

    fetch(`../api/matriculas/read_one.php?id=${id}`)
        .then(response => response.json())
        .then(matricula => {
            const contenedor = document.getElementById('detalles-matricula');

            contenedor.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID Matrícula:</strong> ${matricula.matricula_id}</p>
                        <p><strong>Estudiante:</strong> ${matricula.estudiante_nombre}</p> <!-- Nombre del estudiante -->
                        <p><strong>Curso:</strong> ${matricula.curso_nombre}</p> <!-- Nombre del curso -->
                    </div>
                    <div class="col-md-6">
                        <p><strong>Fecha de Matrícula:</strong> ${matricula.fecha_matricula}</p>
                        <p><strong>Periodo Académico:</strong> ${matricula.periodo_academico}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="editar.php?id=${matricula.matricula_id}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error al cargar matrícula:', error);
            document.getElementById('detalles-matricula').innerHTML = 
                '<p class="text-danger">Error al cargar los datos de la matrícula.</p>';
        });
});

</script>

<?php include_once '../includes/footer.php'; ?>
