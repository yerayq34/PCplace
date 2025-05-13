<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Obtener todas las categorías
$stmt = $conn->prepare("SELECT idcategory, nombre_categoria FROM category");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestión de Categorías</title>
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
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Categorías</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="admin_dashboard.php">Dashboard Admin</a>
            <a href="productos.php">Productos</a>
            <a href="categorias.php">Categorías</a> <!-- Botón para gestionar categorías -->
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Lista de Categorías</h2>
            <a href="crear_categoria.php" class="button">Crear Categoría</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['idcategory'] ?></td>
                            <td><?= htmlspecialchars($row['nombre_categoria']) ?></td>
                            <td>
                                <a href="modificar_categoria.php?id=<?= $row['idcategory'] ?>" class="button">Modificar</a>
                                <a href="eliminar_categoria.php?id=<?= $row['idcategory'] ?>" class="button" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</a>
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

<?php
$stmt->close();
$conn->close();
?>
