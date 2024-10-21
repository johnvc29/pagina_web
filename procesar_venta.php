<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = ""; // Asegúrate de configurar tu contraseña
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


// Obtener los datos del formulario
$producto_id = $_POST['producto'];
$cantidad = (int)$_POST['cantidad'];

// Consultar información del producto
$sql = "SELECT nombre, precio, stock FROM productos WHERE id = $producto_id";
$result = $conn->query($sql);
$producto = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultado de la Venta</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Resultado de la Venta</h2>
        <?php
        if ($producto) {
            if ($producto['stock'] >= $cantidad) {
                $total = $producto['precio'] * $cantidad;

                // Registrar la venta
                $sql_venta = "INSERT INTO ventas (producto_id, cantidad, total) VALUES ($producto_id, $cantidad, $total)";
                if ($conn->query($sql_venta) === TRUE) {
                    // Actualizar el stock del producto
                    $nuevo_stock = $producto['stock'] - $cantidad;
                    $sql_actualizar = "UPDATE productos SET stock = $nuevo_stock WHERE id = $producto_id";
                    $conn->query($sql_actualizar);

                    echo "<div class='message'>Venta realizada con éxito. Total: $" . $total . "</div>";
                } else {
                    echo "<div class='message'>Error al registrar la venta: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='message'>Stock insuficiente para el producto seleccionado.</div>";
            }
        } else {
            echo "<div class='message'>Producto no encontrado.</div>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>