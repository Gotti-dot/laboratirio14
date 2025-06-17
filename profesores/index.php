<?php include_once '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Profesores</h2>
        <a href="crear.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Profesor
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover" id="tabla-profesores">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Especialidad</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha de Contratación</th>
                    <th>Estado</th>
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
        cargarProfesores();
    });

    function cargarProfesores() {
        fetch('../api/profesores/read.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tabla-profesores tbody');
                tbody.innerHTML = '';

                data.profesores.forEach(profesor => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${profesor.profesor_id}</td>
                        <td>${profesor.nombre}</td>
                        <td>${profesor.apellido}</td>
                        <td>${profesor.especialidad}</td>
                        <td>${profesor.email}</td>
                        <td>${profesor.telefono || 'N/A'}</td>
                        <td>${profesor.fecha_contratacion}</td>
                        <td>${parseInt(profesor.activo) === 1 ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <a href="ver.php?id=${profesor.profesor_id}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="editar.php?id=${profesor.profesor_id}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="eliminarProfesor(${profesor.profesor_id})" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function eliminarProfesor(id) {
        if(confirm('¿Está seguro de eliminar este profesor?')) {
            fetch('../api/profesores/delete.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                cargarProfesores();
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>

<?php include_once '../includes/footer.php'; ?>
