<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Valida que el nombre de usuario no esté ya en uso
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "El nombre de usuario ya está en uso.";
        header("Location: register.php");
        exit();
    }

    // Encripta la contraseña en Hash bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepara la consulta para insertar el nuevo usuario
    $stmt = $conn->prepare("INSERT INTO users (username, contraseña, email, nombre, apellidos) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashedPassword, $email, $nombre, $apellidos);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registro exitoso. Puedes iniciar sesión ahora.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Error al registrar: " . $stmt->error;
        header("Location: register.php");
        exit();
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
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Registro de Usuario</h1>
        <nav>
            <a href="login.php">Iniciar Sesión</a>
            <a href="index.php">Inicio</a>
        </nav>
    </header>

    <main>
        <div class="container">
            <form action="register.php" method="POST" class="login-form">
                <h2>Crear cuenta</h2>
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<p style='color:red;'>{$_SESSION['error']}</p>";
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo "<p style='color:green;'>{$_SESSION['success']}</p>";
                    unset($_SESSION['success']);
                }
                ?>
                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="input-group">
                    <label for="apellido">Apellidos</label> 
                    <input type="text" id="apellido" name="apellido" required>
                </div>

                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="username">Nombre de Usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">Registrarse</button>
                <div class="signup-link">
                    ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
    </footer>
</body>
</html>