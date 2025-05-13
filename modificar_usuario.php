<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$iduser = $_GET['id'] ?? null;

if (!$iduser) {
    echo "ID de usuario no válido.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, rol = ? WHERE iduser = ?");
    $stmt->bind_param("sssi", $username, $email, $rol, $iduser);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}

$stmt = $conn->prepare("SELECT username, email, rol FROM users WHERE iduser = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "Usuario no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Usuario</title>
</head>
<body>
    <h2>Modificar Usuario</h2>
    <form method="POST">
        <label>Usuario:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
        <label>Rol:</label><br>
        <select name="rol">
            <option value="user" <?= $user['rol'] === 'user' ? 'selected' : '' ?>>Usuario</option>
            <option value="admin" <?= $user['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
        </select><br><br>
        <button type="submit">Guardar cambios</button>
        <a href="admin_dashboard.php">Cancelar</a>
    </form>
</body>
</html>
