<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$iduser = $_GET['id'] ?? null;

if (!$iduser) {
    echo "ID no válido.";
    exit();
}

// Evitar que el admin se elimine a sí mismo
if ($_SESSION['iduser'] == $iduser) {
    echo "No puedes eliminar tu propia cuenta mientras estás conectado.";
    exit();
}

$stmt = $conn->prepare("DELETE FROM users WHERE iduser = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();