<?php include_once '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Crear Nuevo Profesor</h2>

    <form id="form-crear-profesor">
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
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('form-crear-profesor').addEventListener('submit', function(e) {
        e.preventDefault();

        const profesor = {
            nombre: document.getElementById('nombre').value,
            apellido: document.getElementById('apellido').value,
            especialidad: document.getElementById('especialidad').value,
            telefono: document.getElementById('telefono').value,
            email: document.getElementById('email').value,
            fecha_contratacion: document.getElementById('fecha_contratacion').value,
            activo: document.getElementById('activo').value
        };

        fetch('../api/profesores/create.php', {
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
                window.location.href = 'index.php';
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<?php include_once '../includes/footer.php'; ?>
