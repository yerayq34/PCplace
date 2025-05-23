<?php
session_start();
include 'db.php';

// Inicializar el carrito si no existe
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "El carrito está vacío.";
    exit;
}

// Obtener los IDs de los productos en el carrito
$productIds = implode(',', array_keys($_SESSION['cart']));
$sql = "SELECT idproduct, nombre_producto, pvp FROM products WHERE idproduct IN ($productIds)";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Vincula tu archivo CSS -->
    <title>Carrito de Compras - PCPlace</title>
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

        main {
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
        }

        .button {
            background-color: #4CAF50; /* Verde */
            color: white;
            border: none;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .remove-button {
            background-color: #f44336; /* Rojo */
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
        <a href="cart_view.php">Carrito</a>
        <div class="dropdown">
            <button class="dropbtn">
                <img src="images/user-icon.png" alt="Usuario" class="user-icon"> <!-- Icono de usuario -->
                ▼
            </button>
            <div class="dropdown-content">
                <?php if (isset($_SESSION['username'])): ?>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <a href="admin_dashboard.php">Mi Cuenta</a>
                    <?php else: ?>
                        <a href="dashboard.php">Mi Cuenta</a>
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
        <h2>Carrito de Compras</h2>
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nombre_producto'] ?></td>
                    <td>€<?= $row['pvp'] ?></td>
                    <td>
                        <form method="POST" action="update_cart.php">
                            <input type="hidden" name="product_id" value="<?= $row['idproduct'] ?>">
                            <input type="number" name="quantity" value="<?= $_SESSION['cart'][$row['idproduct']] ?>" min="1" style="width: 50px;">
                            <button type="submit" class="button">Actualizar</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="remove_from_cart.php">
                            <input type="hidden" name="product_id" value="<?= $row['idproduct'] ?>">
                            <button type="submit" class="button remove-button">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php" class="button">Seguir comprando</a>
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
