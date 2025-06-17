<?php include_once '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Registrar Nueva Matrícula</h2>

    <form id="form-crear-matricula">
        <div class="mb-3">
            <label for="estudiante_id" class="form-label">Estudiante</label>
            <select class="form-select" id="estudiante_id" required>
                <!-- Opciones de estudiantes cargadas dinámicamente -->
            </select>
        </div>

        <div class="mb-3">
            <label for="curso_id" class="form-label">Curso</label>
            <select class="form-select" id="curso_id" required>
                <!-- Opciones de cursos cargadas dinámicamente -->
            </select>
        </div>

        <div class="mb-3">
            <label for="periodo_academico" class="form-label">Periodo Académico</label>
            <input type="text" class="form-control" id="periodo_academico" required>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="index.php" class="btn btn-secondary me-md-2">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar Matrícula
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        cargarEstudiantes();
        cargarCursos();
    });

    function cargarEstudiantes() {
        fetch('../api/estudiantes/read.php')
            .then(response => response.json())
            .then(data => {
                const selectEstudiante = document.getElementById('estudiante_id');
                selectEstudiante.innerHTML = '';

                data.estudiantes.forEach(estudiante => {
                    const option = document.createElement('option');
                    option.value = estudiante.estudiante_id;
                    option.textContent = `${estudiante.nombre} ${estudiante.apellido}`;
                    selectEstudiante.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar estudiantes:', error));
    }

    function cargarCursos() {
        fetch('../api/cursos/read.php')
            .then(response => response.json())
            .then(data => {
                const selectCurso = document.getElementById('curso_id');
                selectCurso.innerHTML = '';

                data.cursos.forEach(curso => {
                    const option = document.createElement('option');
                    option.value = curso.curso_id;
                    option.textContent = curso.nombre;
                    selectCurso.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar cursos:', error));
    }

    document.getElementById('form-crear-matricula').addEventListener('submit', function(e) {
        e.preventDefault();

        const matricula = {
            estudiante_id: document.getElementById('estudiante_id').value,
            curso_id: document.getElementById('curso_id').value,
            periodo_academico: document.getElementById('periodo_academico').value
        };

        fetch('../api/matriculas/create.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(matricula)
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
