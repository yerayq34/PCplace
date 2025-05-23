<?php
session_start();
include 'db.php';

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1; // Cantidad por defecto es 1

    if (isset($_SESSION['username'])) {
        // Usuario registrado
        $user_id = $_SESSION['iduser']; // Asegúrate de que el ID del usuario esté en la sesión

        // Verificar si el producto ya está en el carrito
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE iduser = ? AND idproduct = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Actualizar la cantidad
            $row = $result->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE iduser = ? AND idproduct = ?");
            $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
        } else {
            // Insertar nuevo producto en el carrito
            $stmt = $conn->prepare("INSERT INTO cart (iduser, idproduct, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        }
        $stmt->execute();
    } else {
        // Usuario no registrado
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Verificar si el producto ya está en el carrito
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity; // Aumentar la cantidad
        } else {
            $_SESSION['cart'][$product_id] = $quantity; // Agregar nuevo producto
        }
    }

    header("Location: index.php"); // Redirigir a la página de inicio o donde desees
    exit();
}
?>
