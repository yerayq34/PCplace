<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $productId = intval($_POST['product_id']);

    if ($action === 'add') {
        if (!in_array($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $productId;
            echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'El producto ya está en el carrito.']);
        }
    } elseif ($action === 'remove') {
        if (($key = array_search($productId, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito.']);
        }
    }
}
?>
