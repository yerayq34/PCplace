<?php
session_start(); // Iniciar la sesión

// Incluir el archivo de conexión a la base de datos
include 'db.php';

// Consulta para obtener productos, incluyendo la columna 'imagen'
$sql = "SELECT nombre_producto, short_desc, pvp, imagen FROM products"; // Asegúrate de que la tabla y columnas existan
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Vincula tu archivo CSS -->
    <title>Inicio - PCPlace</title>
</head>
<body>
<header>
    <h1>PCPlace</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <div class="dropdown">
            <button class="dropbtn">
                <img src="images/user-icon.png" alt="Usuario" class="user-icon"> <!-- Icono de usuario -->
                ▼
            </button>
            <div class="dropdown-content">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="dashboard.php">Mi Cuenta</a>
                    <a href="logout.php">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.php">Iniciar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
<main>
    <div class="container">
        <h2>Productos Destacados</h2>
        <div class="product-grid"> 
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre_producto']; ?>" /> <!-- Mostrar la imagen -->
                        <h3><?php echo $row['nombre_producto']; ?></h3>
                        <p><?php echo $row['short_desc']; ?></p>
                        <p>Precio: $<?php echo $row['pvp']; ?></p>
                        <button>Añadir al Carrito</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
<footer>
    <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
</footer>
</body>
</html>

<?php
$conn->close();
?>