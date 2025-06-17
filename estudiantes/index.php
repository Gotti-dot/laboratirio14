<?php include_once '../includes/header.php'; ?>


<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Estudiantes</h2>
        <a href="crear.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Estudiante
        </a>
    </div>


    <div class="table-responsive">
        <table class="table table-striped table-hover" id="tabla-estudiantes">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Teléfono</th>
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
        cargarEstudiantes();
    });


    function cargarEstudiantes() {
        fetch('../api/estudiantes/read.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tabla-estudiantes tbody');
                tbody.innerHTML = '';


                data.estudiantes.forEach(estudiante => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${estudiante.estudiante_id}</td>
                        <td>${estudiante.nombre}</td>
                        <td>${estudiante.apellido}</td>
                        <td>${estudiante.email}</td>
                        <td>${estudiante.telefono || 'N/A'}</td>
                        <td>
                            <a href="ver.php?id=${estudiante.estudiante_id}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="editar.php?id=${estudiante.estudiante_id}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="eliminarEstudiante(${estudiante.estudiante_id})" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error:', error));
    }


    function eliminarEstudiante(id) {
        if(confirm('¿Está seguro de eliminar este estudiante?')) {
            fetch('../api/estudiantes/delete.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                cargarEstudiantes();
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>


<?php include_once '../includes/footer.php'; ?>
