<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT nombre_producto, short_desc, description, pvp, imagen FROM products WHERE idproduct = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product); // Devolver los detalles del producto en formato JSON
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID de producto no proporcionado']);
}

$stmt->close();
$conn->close();
?>
