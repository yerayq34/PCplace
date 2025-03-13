<?php
session_start(); // Iniciar la sesión

// Con este archivo se conecta con la base de datos

include 'db.php';

// Verificar si se ha enviado el formulario

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = $_POST['username'];

    $pass = $_POST['password'];


   // Preparar la consulta para evitar inyecciones SQL

   $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");

   $stmt->bind_param("s", $user);

   $stmt->execute();

   $result = $stmt->get_result();


   // Verificar si se encontró el usuario en la base de ddtos

   if ($result->num_rows > 0) {

       $row = $result->fetch_assoc();

       // Verificar la contraseña (suponiendo que la contraseña está almacenada como hash)

       if (password_verify($pass, $row['contraseña'])) {

           // Iniciar sesión

           $_SESSION['username'] = $row['username'];

           header("Location: dashboard.php"); // Redirigir a la página de dashboard para tener del usuario

           exit();

       } else {

           echo "Usuario o contraseña incorrectos.";

       }

   } else {

       echo "Usuario o contraseña incorrectos.";

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
    <title>Iniciar Sesión</title>
</head>
<body>
    <header>
        <h1>PCPlace</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="dashboard.php">Mi Cuenta</a>
            <a href="carrito.php">Carrito</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <form class="login-form" method="POST" action="login.php">
                <h2>Iniciar Sesión</h2>
                <div class="input-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Entrar</button>
                <p class="signup-link">¿No tienes una cuenta? <a href="#">Regístrate</a></p>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
    </footer>
</body>
</html>

