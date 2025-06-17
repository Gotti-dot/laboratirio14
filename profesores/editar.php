<?php
$id = $_GET['id'] ?? null;
if(!$id) {
    header('Location: index.php');
    exit;
}
include_once '../includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Editar Profesor</h2>

    <form id="form-editar-profesor">
        <input type="hidden" id="profesor_id" value="<?php echo $id; ?>">

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
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <input type="text" class="form-control" id="especialidad" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
                    <input type="date" class="form-control" id="fecha_contratacion" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="activo" class="form-label">Estado</label>
                    <select class="form-select" id="activo">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
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

        // Cargar datos del profesor
        fetch(`../api/profesores/read_one.php?id=${id}`)
            .then(response => response.json())
            .then(profesor => {
                document.getElementById('nombre').value = profesor.nombre;
                document.getElementById('apellido').value = profesor.apellido;
                document.getElementById('especialidad').value = profesor.especialidad;
                document.getElementById('telefono').value = profesor.telefono || '';
                document.getElementById('email').value = profesor.email;
                document.getElementById('fecha_contratacion').value = profesor.fecha_contratacion;
                document.getElementById('activo').value = profesor.activo ? '1' : '0';
            })
            .catch(error => console.error('Error:', error));

        // Manejar el envío del formulario
        document.getElementById('form-editar-profesor').addEventListener('submit', function(e) {
            e.preventDefault();

            const profesor = {
                profesor_id: id,
                nombre: document.getElementById('nombre').value,
                apellido: document.getElementById('apellido').value,
                especialidad: document.getElementById('especialidad').value,
                telefono: document.getElementById('telefono').value,
                email: document.getElementById('email').value,
                fecha_contratacion: document.getElementById('fecha_contratacion').value,
                activo: document.getElementById('activo').value
            };

            fetch('../api/profesores/update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(profesor)
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
