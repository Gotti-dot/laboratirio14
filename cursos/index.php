<?php include_once '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Cursos</h2>
        <a href="crear.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Curso
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover" id="tabla-cursos">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Profesor</th>
                    <th>Horario</th>
                    <th>Aula</th>
                    <th>Créditos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se cargarán con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<script src="../assets/js/script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        cargarCursos();
    });

    function cargarCursos() {
        fetch('../api/cursos/read.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tabla-cursos tbody');
                tbody.innerHTML = '';

                data.cursos.forEach(curso => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${curso.curso_id}</td>
                        <td>${curso.nombre}</td>
                        <td>${curso.descripcion}</td>
                        <td>${curso.profesor_id}</td>
                        <td>${curso.horario}</td>
                        <td>${curso.aula}</td>
                        <td>${curso.creditos}</td>
                        <td>
                            <a href="ver.php?id=${curso.curso_id}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="editar.php?id=${curso.curso_id}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="eliminarCurso(${curso.curso_id})" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error al cargar cursos:', error));
    }

    function eliminarCurso(id) {
        if(confirm('¿Está seguro de eliminar este curso?')) {
            fetch('../api/cursos/delete.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ curso_id: id })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                cargarCursos();
            })
            .catch(error => console.error('Error al eliminar curso:', error));
        }
    }
</script>

<?php include_once '../includes/footer.php'; ?>
