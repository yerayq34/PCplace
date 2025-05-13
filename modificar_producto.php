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
    $nombre = $_POST['nombre_producto'];
    $short = $_POST['short_desc'];
    $desc = $_POST['description'];
    $precio = $_POST['pvp'];

    $stmt = $conn->prepare("UPDATE products SET nombre_producto=?, short_desc=?, description=?, pvp=? WHERE idproduct=?");
    $stmt->bind_param("sssdi", $nombre, $short, $desc, $precio, $id);
    $stmt->execute();

    header("Location: productos.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE idproduct = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
?>

<form method="POST">
    <label>Nombre:</label>
    <input type="text" name="nombre_producto" value="<?= $product['nombre_producto'] ?>"><br>
    <label>Descripción corta:</label>
    <input type="text" name="short_desc" value="<?= $product['short_desc'] ?>"><br>
    <label>Descripción:</label>
    <textarea name="description"><?= $product['description'] ?></textarea><br>
    <label>Precio:</label>
    <input type="number" step="0.01" name="pvp" value="<?= $product['pvp'] ?>"><br>
    <button type="submit">Guardar cambios</button>
</form>
