<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID de categoría no proporcionado.");
}

$stmt = $conn->prepare("SELECT nombre_categoria FROM category WHERE idcategory = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nombre_categoria);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = htmlspecialchars(trim($_POST['nombre_categoria']));

    if (empty($nuevo_nombre)) {
        $_SESSION['error'] = "El nombre de la categoría no puede estar vacío.";
    } else {
        $stmt = $conn->prepare("UPDATE category SET nombre_categoria = ? WHERE idcategory = ?");
        $stmt->bind_param("si", $nuevo_nombre, $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Categoría modificada correctamente.";
            header("Location: categorias.php");
            exit();
        } else {
            $_SESSION['error'] = "Error al modificar la categoría: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Categoría</title>
</head>
<body>
    <h2>Modificar Categoría</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST">
        <label for="nombre_categoria">Nombre de la Categoría:</label>
        <input type="text" id="nombre_categoria" name="nombre_categoria" value="<?= htmlspecialchars($nombre_categoria) ?>" required>
        <button type="submit">Modificar Categoría</button>
    </form>
    <a href="categorias.php">Volver a la lista de categorías</a>
</body>
</html>
