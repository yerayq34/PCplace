<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Consultar la base de datos para obtener información del usuario.
$stmt = $conn->prepare("SELECT nombre, apellidos, email FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $email);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = $_POST['nombre'];
    $nuevo_apellido = $_POST['apellidos'];
    $nuevo_email = $_POST['email'];

    // Actualizar la información del usuario
    $stmt = $conn->prepare("UPDATE users SET nombre = ?, apellidos = ?, email = ? WHERE username = ?");
    $stmt->bind_param("ssss", $nuevo_nombre, $nuevo_apellido, $nuevo_email, $username);

    if ($stmt->execute()) {
        echo "Datos actualizados correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Modificar Datos</title>
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
            <h2>Modificar Datos</h2>
            <form method="POST" action="modify.php">
                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </div>
                <div class="input-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($apellido); ?>" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <button type="submit">Actualizar</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
    </footer>
</body>
</html>