<?php
$servername = "localhost"; // Esto es el nombre del servidor MYSQL
$username = "root"; // Usuario de base de datos con que se conecta.
$password = "root"; // La contraseña del usuario, que se conecta con mysql
$dbname = "PCPlace"; // ESto es el nombre de la base de datos que se conecta.

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión con la base de datos, y si no se conecta entonces sale un error de conexion.
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
