<?php
$servername = "localhost";
$username = "root";
$password = ""; // Asegúrate de configurar tu contraseña
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    
    // Aquí, añade la lógica para manejar la recuperación de la contraseña
    // Por ejemplo, puedes generar un token de recuperación y enviarlo por correo electrónico
    
    // Ejemplo básico de mensaje (esto no envía un correo real)
    echo "Se ha enviado un enlace de recuperación a $email";
}

$conn->close();
?>