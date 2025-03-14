<?php
session_start();

$_SESSION = array(); // Salimos del usuario en que se este logeado

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Con esto eleminamos la session iniciada actualmente
session_destroy(); 

// Redirigir a la página de inicio de sesión
header("Location: login.php");
exit();
?>
