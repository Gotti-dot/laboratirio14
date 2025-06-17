<?php include_once '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Crear Nuevo Curso</h2>

    <form id="form-crear-curso">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Curso</label>
            <input type="text" class="form-control" id="nombre" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="profesor_id" class="form-label">Profesor Asignado</label>
            <select class="form-select" id="profesor_id" required>
                <!-- Opciones de profesores cargadas dinámicamente -->
            </select>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="horario" class="form-label">Horario</label>
                    <input type="text" class="form-control" id="horario" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="aula" class="form-label">Aula</label>
                    <input type="text" class="form-control" id="aula" required>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="creditos" class="form-label">Créditos</label>
            <input type="number" class="form-control" id="creditos" required>
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
    document.addEventListener('DOMContentLoaded', function() {
        cargarProfesores();
    });

    function cargarProfesores() {
        fetch('../api/profesores/read.php')
            .then(response => response.json())
            .then(data => {
                const selectProfesor = document.getElementById('profesor_id');
                selectProfesor.innerHTML = '';

                data.profesores.forEach(profesor => {
                    const option = document.createElement('option');
                    option.value = profesor.profesor_id;
                    option.textContent = `${profesor.nombre} ${profesor.apellido}`;
                    selectProfesor.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar profesores:', error));
    }

    document.getElementById('form-crear-curso').addEventListener('submit', function(e) {
        e.preventDefault();

        const curso = {
            nombre: document.getElementById('nombre').value,
            descripcion: document.getElementById('descripcion').value,
            profesor_id: document.getElementById('profesor_id').value,
            horario: document.getElementById('horario').value,
            aula: document.getElementById('aula').value,
            creditos: document.getElementById('creditos').value
        };

        fetch('../api/cursos/create.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(curso)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if(data.status === "success") {
                window.location.href = 'index.php';
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<?php include_once '../includes/footer.php'; ?>
