<?php
session_start();
require 'db.php';

// Verificar permisos de admin
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Obtener categorías 
$categorias = $conn->query("SELECT idcategory, nombre_categoria FROM category");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        
        $nombre_producto = htmlspecialchars(trim($_POST['nombre_producto']));
        $idcategoria = (int)$_POST['idcategoria'];
        $pvp = (float)str_replace(',', '.', $_POST['pvp']);
        $description = htmlspecialchars(trim($_POST['description']));
        $short_desc = htmlspecialchars(trim($_POST['short_desc']));

        // Validaciones
        if (empty($nombre_producto) || strlen($nombre_producto) > 60) {
            throw new Exception("Nombre inválido (máx. 60 caracteres)");
        }

        if ($pvp <= 0 || $pvp > 9999.99) {
            throw new Exception("Precio debe ser entre 0.01 y 9999.99");
        }

        // Verificar categoría existente
        $check_cat = $conn->prepare("SELECT 1 FROM category WHERE idcategory = ?");
        $check_cat->bind_param("i", $idcategoria);
        $check_cat->execute();
        
        if (!$check_cat->get_result()->num_rows) {
            throw new Exception("Categoría no válida");
        }

        // Insertar producto
        $stmt = $conn->prepare("INSERT INTO products 
                              (nombre_producto, idcategory, pvp, description, short_desc) 
                              VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sidss", $nombre_producto, $idcategoria, $pvp, $description, $short_desc);

        if (!$stmt->execute()) {
            throw new Exception("Error en base de datos: " . $stmt->error);
        }

        $_SESSION['success'] = "Producto añadido correctamente";
        header("Location: admin.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto - Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Añadir Producto</h1>
            <nav class="admin-nav">
                <a href="index.php" class="nav-link">Inicio</a>
                <a href="admin_dashboard.php" class="nav-link">Dashboard Admin</a>
                <a href="productos.php" class="nav-link">Productos</a>
                <a href="logout.php" class="nav-link">Cerrar Sesión</a>
            </nav>
        </header>

        <main class="admin-main">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert error">
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert success">
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="product-form">
                <div class="form-group">
                    <label for="nombre_producto" class="form-label">Nombre</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" 
                           class="form-input" required maxlength="60">
                </div>

                <div class="form-group">
                    <label for="idcategoria" class="form-label">Categoría</label>
                    <select id="idcategoria" name="idcategoria" class="form-select" required>
                        <?php while ($cat = $categorias->fetch_assoc()): ?>
                            <option value="<?= $cat['idcategory'] ?>">
                                <?= htmlspecialchars($cat['nombre_categoria']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pvp" class="form-label">Precio (€)</label>
                    <input type="text" id="pvp" name="pvp" class="form-input" 
                           required pattern="[0-9]+([\.,][0-9]{1,2})?">
                </div>

                <div class="form-group">
                    <label for="short_desc" class="form-label">Descripción Corta</label>
                    <input type="text" id="short_desc" name="short_desc" 
                           class="form-input" required maxlength="255">
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Descripción Completa</label>
                    <textarea id="description" name="description" 
                              class="form-textarea" required></textarea>
                </div>

                <button type="submit" class="form-submit">Guardar Producto</button>
            </form>
        </main>

        <footer class="admin-footer">
            <p>&copy; 2025 PCPlace. Hecho por Tarun y Yeray.</p>
        </footer>
    </div>
</body>
</html>
