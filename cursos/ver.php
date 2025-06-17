<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}
include_once '../includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Detalles del Curso</h2>

    <div class="card">
        <div class="card-body" id="detalles-curso">
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

        fetch(`../api/cursos/read_one.php?id=${id}`)
            .then(response => response.json())
            .then(curso => {
                const contenedor = document.getElementById('detalles-curso');

                contenedor.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> ${curso.curso_id}</p>
                            <p><strong>Nombre:</strong> ${curso.nombre}</p>
                            <p><strong>Descripción:</strong> ${curso.descripcion}</p>
                            <p><strong>Profesor ID:</strong> ${curso.profesor_id}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Horario:</strong> ${curso.horario}</p>
                            <p><strong>Aula:</strong> ${curso.aula}</p>
                            <p><strong>Créditos:</strong> ${curso.creditos}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="editar.php?id=${curso.curso_id}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error al cargar curso:', error);
                document.getElementById('detalles-curso').innerHTML = 
                    '<p class="text-danger">Error al cargar los datos del curso.</p>';
            });
    });
</script>

<?php include_once '../includes/footer.php'; ?>
