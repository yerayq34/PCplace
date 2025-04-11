<?php
session_start(); // Se inicia la sesión

// Mostrar errores si el PHP tiene algún tipo de error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Comprobar si el usuario ha iniciado sesión.
// Si no es así, se redirige a la página de inicio de sesión.
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirige si no hay sesión activa.
    exit();
}

// Con este archivo de conexión con la base de datos.
include 'db.php';

// Obtener el nombre de usuario de la sesión.
$username = $_SESSION['username'];

// Consultar la base de datos para obtener información del usuario.
$stmt = $conn->prepare("SELECT nombre, apellidos, email FROM users WHERE username = ?");
$stmt->bind_param("s", $username); // Asignar el valor del usuario en la consulta.
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $email); // Guardar los resultados en variables.
$stmt->fetch(); // Obtener los datos.
$stmt->close(); // Cerrar la consulta.

// Comprobar si se obtuvieron datos del usuario.
if (!$nombre || !$apellido || !$email) {
    echo "Error: No se encontró información del usuario.";
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
    <style>
        .profile-icon {
            width: 100px; /* Ajusta el tamaño según sea necesario */
            height: 100px; /* Ajusta el tamaño según sea necesario */
            border-radius: 50%; /* Hace que la imagen sea circular */
            object-fit: cover; /* Asegura que la imagen se ajuste bien */
        }
        .modify-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF; /* Color de fondo del botón */
            color: white; /* Color del texto */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cambia el cursor al pasar el ratón */
        }
        .modify-button:hover {
            background-color: #0056b3; /* Color de fondo al pasar el ratón */
        }
    </style>
</head>
<body>
    <header>
        <h1>PCPLACE</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="dashboard.php">Mi Cuenta</a>
            <a href="carrito.php">Carrito</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Hola, <?php echo htmlspecialchars($nombre); ?>!</h2>
            <img src="path/to/your/profile-icon.png" alt="Ícono de perfil" class="profile-icon"> <!-- Cambia la ruta a tu imagen -->
            <p>Nombre: <?php echo htmlspecialchars($nombre); ?></p>
            <p>Apellido: <?php echo htmlspecialchars($apellido); ?></p>
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
            <p>Este es tu panel de control. Aquí puedes gestionar tu cuenta.</p>
            <a href="modify.php" class="modify-button">Modificar Datos</a> <!-- Enlace al formulario de modificación -->
        </div>
    </main>
    <footer>
        <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
    </footer>
</body>
</html>