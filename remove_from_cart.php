<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    unset($_SESSION['cart'][$productId]); // Eliminar el producto del carrito
}

header("Location: cart_view.php"); // Redirigir de vuelta al carrito
exit;
?>
