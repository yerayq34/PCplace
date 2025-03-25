<?php
session_start();
include 'db.php'; // Incluir la conexión a la base de datos

// Verificar si el usuario es admin
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php"); // Redirigir si no es admin
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_producto = $_POST['nombre_producto'];
    $idcategoria = $_POST['idcategoria'];
    $pvp = $_POST['pvp'];
    $description = $_POST['description'];
    $short_desc = $_POST['short_desc'];

    // Preparar la consulta para insertar el nuevo producto
    $stmt = $conn->prepare("INSERT INTO products (nombre_producto, idcategory, pvp, description, short_desc) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sids", $nombre_producto, $idcategoria, $pvp, $description, $short_desc); // 's' para string, 'i' para integer, 'd' para double

    if ($stmt->execute()) {
        $_SESSION['success'] = "Producto añadido exitosamente.";
        header("Location: admin.php"); // Redirigir a la misma página para añadir más productos
        exit();
    } else {
        $_SESSION['error'] = "Error al añadir el producto: " . $stmt->error;
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
    <title>Añadir Producto</title>
</head>
<body>
    <header>
        <h1>Añadir Producto</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="admin_dashboard.php">Dashboard Admin</a>
            <a href="productos.php">Productos</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Formulario para Añadir Producto</h2>
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
            <form action="admin.php" method="POST">
                <div class="input-group">
                    <label for="nombre_producto">Nombre del Producto</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" required>
                </div>
                <div class="input-group">
                    <label for="idcategoria">Categoría ID</label>
                    <input type="number" id="idcategoria" name="idcategoria" required>
                </div>
                <div class="input-group">
                    <label for="pvp">Precio (PVP)</label>
                    <input type="text" id="pvp" name="pvp" required>
                </div>
                <div class="input-group">
                    <label for="short_desc">Descripción Corta</label>
                    <input type="text" id="short_desc" name="short_desc" required>
                </div>
                <div class="input-group">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <button type="submit">Añadir Producto</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
    </footer>
</body>
</html>