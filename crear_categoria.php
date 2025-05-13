<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_categoria = htmlspecialchars(trim($_POST['nombre_categoria']));

    if (empty($nombre_categoria)) {
        $_SESSION['error'] = "El nombre de la categoría no puede estar vacío.";
    } else {
        $stmt = $conn->prepare("INSERT INTO category (nombre_categoria) VALUES (?)");
        $stmt->bind_param("s", $nombre_categoria);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Categoría creada correctamente.";
            header("Location: categorias.php");
            exit();
        } else {
            $_SESSION['error'] = "Error al crear la categoría: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Categoría</title>
</head>
<body>
    <h2>Crear Nueva Categoría</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST">
        <label for="nombre_categoria">Nombre de la Categor ía:</label>
        <input type="text" id="nombre_categoria" name="nombre_categoria" required>
        <button type="submit">Crear Categoría</button>
    </form>
    <a href="categorias.php">Volver a la lista de categorías</a>
</body>
</html>
