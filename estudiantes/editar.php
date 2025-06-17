<?php
$id = $_GET['id'] ?? null;
if(!$id) {
    header('Location: index.php');
    exit;
}
include_once '../includes/header.php';
?>


<div class="container mt-5">
    <h2 class="mb-4">Editar Estudiante</h2>
   
    <form id="form-editar-estudiante">
        <input type="hidden" id="estudiante_id" value="<?php echo $id; ?>">
       
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" required>
                </div>
            </div>
        </div>
       
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="genero" class="form-label">Género</label>
                    <select class="form-select" id="genero">
                        <option value="" selected>Seleccionar...</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            </div>
        </div>
       
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion">
        </div>
       
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
            </div>
        </div>
       
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="index.php" class="btn btn-secondary me-md-2">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const id = <?php echo $id; ?>;
       
        // Cargar datos del estudiante
        fetch(`../api/estudiantes/read_one.php?id=${id}`)
            .then(response => response.json())
            .then(estudiante => {
                document.getElementById('nombre').value = estudiante.nombre;
                document.getElementById('apellido').value = estudiante.apellido;
                document.getElementById('fecha_nacimiento').value = estudiante.fecha_nacimiento;
                document.getElementById('genero').value = estudiante.genero || '';
                document.getElementById('direccion').value = estudiante.direccion || '';
                document.getElementById('telefono').value = estudiante.telefono || '';
                document.getElementById('email').value = estudiante.email;
            })
            .catch(error => console.error('Error:', error));
       
        // Manejar el envío del formulario
        document.getElementById('form-editar-estudiante').addEventListener('submit', function(e) {
            e.preventDefault();
           
            const estudiante = {
                estudiante_id: id,
                nombre: document.getElementById('nombre').value,
                apellido: document.getElementById('apellido').value,
                fecha_nacimiento: document.getElementById('fecha_nacimiento').value,
                genero: document.getElementById('genero').value,
                direccion: document.getElementById('direccion').value,
                telefono: document.getElementById('telefono').value,
                email: document.getElementById('email').value
            };
           
            fetch('../api/estudiantes/update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(estudiante)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if(data.message.includes("correctamente")) {
                    window.location.href = 'ver.php?id=' + id;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>


<?php include_once '../includes/footer.php'; ?>
