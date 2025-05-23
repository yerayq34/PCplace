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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        nav .dropdown {
            position: relative;
            display: inline-block;
        }

        nav .dropbtn {
            background-color: transparent;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        nav .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        nav .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        nav .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        nav .dropdown:hover .dropdown-content {
            display: block;
        }

        main {
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }

        .product-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 200px; /* Ancho fijo para los productos */
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card img {
            max-width: 100%;
            height: auto; /* Mantener la proporción de la imagen */
            border-radius: 4px;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<header>
    <h1>PCPlace</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="cart_view.php">Carrito</a> <!-- Botón de carrito añadido -->
        <div class="dropdown">
            <button class="dropbtn">
                <img src="images/user-icon.png" alt="Usuario" class="user-icon"> <!-- Icono de usuario -->
                ▼
            </button>
            <div class="dropdown-content">
                <?php if (isset($_SESSION['username'])): ?>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <a href="admin_dashboard.php">Mi Cuenta</a> <!-- Redirigir a admin_dashboard.php si es admin -->
                    <?php else: ?>
                        <a href="dashboard.php">Mi Cuenta</a> <!-- Redirigir a dashboard.php si es user -->
                    <?php endif; ?>
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
