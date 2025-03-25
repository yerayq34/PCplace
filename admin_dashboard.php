<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario es admin
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php"); // Redirigir si no es admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard Admin</title>
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="admin_dashboard.php">Dashboard Admin</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>Este es tu panel de control como administrador.</p>
            <div class="button-container">
                <a href="admin.php" class="button">Añadir Productos</a>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
    </footer>
</body>
</html>
