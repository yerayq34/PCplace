<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario es admin
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') { // Verificar el rol
    header("Location: login.php"); // Redirigir si no es admin
    exit();
}


include 'db.php';

// Consultar la base de datos para obtener todos los productos junto con el nombre de la categoría
$stmt = $conn->prepare("
    SELECT p.idproduct, p.nombre_producto, p.pvp, p.description, p.short_desc, c.nombre_categoria 
    FROM products p 
    JOIN category c ON p.idcategory = c.idcategory
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestión de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        th, td {
            padding: 10px;
            text-align: left; 
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .data-cell {
            background-color: #f9f9f9;
            border: 1px solid #ddd; 
            border-radius: 4px; 
            padding: 8px; 
            color: #333; 
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Productos</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="admin_dashboard.php">Dashboard Admin</a>
            <a href="productos.php">Productos</a> 
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Opciones de Gestión de Productos</h2>
            <div class="button-container">
                <a href="añadirproducto.php" class="button">Añadir Producto</a>
                <a href="modify_product.php" class="button">Modificar Producto</a>
                <a href="delete_product.php" class="button">Eliminar Producto</a>
            </div>

            <h2>Lista de Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Producto</th>
                        <th>Descripción Corta</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="data-cell"><?php echo htmlspecialchars($row['idproduct']); ?></td>
                            <td class="data-cell"><?php echo htmlspecialchars($row['nombre_producto']); ?></td>
                            <td class="data-cell"><?php echo htmlspecialchars($row['short_desc']); ?></td>
                            <td class="data-cell"><?php echo htmlspecialchars($row['description']); ?></td>
                            <td class="data-cell"><?php echo htmlspecialchars($row['pvp']); ?></td>
                            <td class="data-cell"><?php echo htmlspecialchars($row['nombre_categoria']); ?></td>
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
$stmt->close(); // Cerrar la consulta
$conn->close(); // Cerrar la conexión a la base de datos
?>