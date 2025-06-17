<?php
$id = $_GET['id'] ?? null;
if(!$id) {
    header('Location: index.php');
    exit;
}
include_once '../includes/header.php';
?>


<div class="container mt-5">
    <h2 class="mb-4">Detalles del Estudiante</h2>
   
    <div class="card">
        <div class="card-body" id="detalles-estudiante">
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
       
        fetch(`../api/estudiantes/read_one.php?id=${id}`)
            .then(response => response.json())
            .then(estudiante => {
                const contenedor = document.getElementById('detalles-estudiante');
               
                const fechaNac = new Date(estudiante.fecha_nacimiento).toLocaleDateString();
                const fechaIng = new Date(estudiante.fecha_ingreso).toLocaleDateString();
               
                contenedor.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> ${estudiante.estudiante_id}</p>
                            <p><strong>Nombre:</strong> ${estudiante.nombre}</p>
                            <p><strong>Apellido:</strong> ${estudiante.apellido}</p>
                            <p><strong>Fecha de Nacimiento:</strong> ${fechaNac}</p>
                            <p><strong>Género:</strong> ${estudiante.genero || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dirección:</strong> ${estudiante.direccion || 'N/A'}</p>
                            <p><strong>Teléfono:</strong> ${estudiante.telefono || 'N/A'}</p>
                            <p><strong>Email:</strong> ${estudiante.email}</p>
                            <p><strong>Fecha de Ingreso:</strong> ${fechaIng}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="editar.php?id=${estudiante.estudiante_id}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                `;
            })
            .catch(error => console.error('Error:', error));
    });
</script>


<?php include_once '../includes/footer.php'; ?>
