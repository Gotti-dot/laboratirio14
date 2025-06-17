<?php include_once 'includes/header.php'; ?>


<div class="container mt-5">
    <h1 class="mb-4">Sistema de Gestión de Colegio</h1>
    <div class="card">
        <div class="card-header">
            <h3>Menú Principal</h3>
        </div>
        <div class="card-body">
            <div class="list-group">
                <a href="estudiantes/index.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-users me-2"></i> Gestionar Estudiantes
                </a>
            </div>
            <div class="list-group mt-3">
                <a href="profesores/index.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-chalkboard-teacher me-2"></i> Gestionar Profesores
                </a>    
            </div>
            <div class="list-group mt-3">
                <a href="cursos/index.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-share"></i> Gestionar Cursos
                </a>    
            </div>
            <div class="list-group mt-3">
                <a href="matriculas/index.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-file"></i> Gestionar Matriculas
                </a>    
            </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>
