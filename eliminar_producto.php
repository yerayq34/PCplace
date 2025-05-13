<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'db.php';

if (!isset($_GET['id'])) {
    die("ID de producto no proporcionado.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("DELETE FROM products WHERE idproduct = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: productos.php");
    exit();
}
?>

<h2>¿Estás seguro de que deseas eliminar este producto?</h2>
<form method="POST">
    <button type="submit">Sí, eliminar</button>
    <a href="productos.php">Cancelar</a>
</form>
