<?php include_once '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Matrículas</h2>
        <a href="crear.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Matrícula
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover" id="tabla-matriculas">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Curso</th>
                    <th>Fecha de Matrícula</th>
                    <th>Periodo Académico</th>
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
        cargarMatriculas();
    });

    function cargarMatriculas() {
        fetch('../api/matriculas/read.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tabla-matriculas tbody');
                tbody.innerHTML = '';

                data.matriculas.forEach(matricula => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${matricula.matricula_id}</td>
                        <td>${matricula.estudiante_nombre}</td> <!-- Nombre del estudiante -->
                        <td>${matricula.curso_nombre}</td> <!-- Nombre del curso -->
                        <td>${matricula.fecha_matricula}</td>
                        <td>${matricula.periodo_academico}</td>
                        <td>
                            <a href="ver.php?id=${matricula.matricula_id}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="editar.php?id=${matricula.matricula_id}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="eliminarMatricula(${matricula.matricula_id})" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error al cargar matrículas:', error));
    }

    function eliminarMatricula(id) {
        if (confirm('¿Está seguro de eliminar esta matrícula?')) {
            fetch('../api/matriculas/delete.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        matricula_id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    cargarMatriculas();
                })
                .catch(error => console.error('Error al eliminar matrícula:', error));
        }
    }
</script>

<?php include_once '../includes/footer.php'; ?>