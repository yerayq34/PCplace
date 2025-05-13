<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Obtener todos los usuarios
$stmt = $conn->prepare("SELECT iduser, username, email, rol FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block;
            padding: 8px 12px;
            margin: 4px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        nav a {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="admin_dashboard.php">Dashboard Admin</a>
            <a href="productos.php">Productos</a> 
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
            <p>Este es tu panel de control como administrador.</p>

            <h2>Gestión de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $user['iduser'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['rol'] ?></td>
                            <td>
                                <a class="button" href="modificar_usuario.php?id=<?= $user['iduser'] ?>">Modificar</a>
                                <a class="button" href="eliminar_usuario.php?id=<?= $user['iduser'] ?>" onclick="return confirm('¿Eliminar usuario?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
    </footer>
</body>
</html>
