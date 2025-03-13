<?php
session_start(); // Iniciar la sesión
include 'db.php'; // Incluir la conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión si no está autenticado
    exit();
}

// Obtener el nombre de usuario de la sesión
$username = $_SESSION['username'];

// Consultar la información del usuario en la base de datos
$query = "SELECT nombre, apellido, email FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    // Si no se encuentra el usuario, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <h1>Bienvenido a tu Dashboard</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="mi-cuenta.php">Mi Cuenta</a>
            <a href="carrito.php">Carrito</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Hola, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>Nombre: <?php echo htmlspecialchars($userData['nombre']); ?></p>
            <p>Apellido: <?php echo htmlspecialchars($userData['apellido']); ?></p>
            <p>Email: <?php echo htmlspecialchars($userData['email']); ?></p>

            <p>Este es tu panel de control. Aquí puedes gestionar tu cuenta y acceder a otras funcionalidades.</p>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
    </footer>
</body>
</html>
