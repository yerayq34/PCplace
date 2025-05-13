<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID de categoría no proporcionado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("DELETE FROM category WHERE idcategory = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: categorias.php");
    exit();
}
?>

<h2>¿Estás seguro de que deseas eliminar esta categoría?</h2>
<form method="POST">
    <button type="submit">Sí, eliminar</button>
    <a href="categorias.php">Cancelar</a>
</form>
