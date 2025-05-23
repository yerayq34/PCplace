<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity < 1) {
        unset($_SESSION['cart'][$productId]); // Eliminar el producto si la cantidad es menor a 1
    } else {
        $_SESSION['cart'][$productId] = $quantity; // Actualizar la cantidad
    }
}

header("Location: cart_view.php"); // Redirigir de vuelta al carrito
exit;
?>
