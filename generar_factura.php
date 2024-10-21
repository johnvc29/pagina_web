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


$ventas_seleccionadas = $_POST['ventas'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Facturación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container_1">
        <h2>Resultado de la Factura</h2>
        
        <?php
        if (!empty($ventas_seleccionadas)) {
            $total_factura = 0;
            foreach ($ventas_seleccionadas as $venta_id) {
                $sql = "SELECT total FROM ventas WHERE id = $venta_id";
                $result = $conn->query($sql);
                $venta = $result->fetch_assoc();
                $total_factura += $venta['total'];
            }

            $numero_factura = 'F-' . date('YmdHis') . '-' . rand(100, 999);
            $sql_factura = "INSERT INTO facturas (numero_factura, total) VALUES ('$numero_factura', $total_factura)";
            
            if ($conn->query($sql_factura) === TRUE) {
                $factura_id = $conn->insert_id;

                foreach ($ventas_seleccionadas as $venta_id) {
                    $sql_venta = "SELECT producto_id, cantidad, total FROM ventas WHERE id = $venta_id";
                    $result = $conn->query($sql_venta);
                    $venta = $result->fetch_assoc();
                    $producto_id = $venta['producto_id'];
                    $cantidad = $venta['cantidad'];
                    $subtotal = $venta['total'];

                    $sql_detalle = "INSERT INTO factura_detalles (factura_id, venta_id, producto_id, cantidad, subtotal)
                                    VALUES ($factura_id, $venta_id, $producto_id, $cantidad, $subtotal)";
                    $conn->query($sql_detalle);
                }

                echo "<div class='message'>Factura generada con éxito. Número de Factura: $numero_factura</div>";
            } else {
                echo "<div class='message error'>Error al generar la factura: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='message error'>No se seleccionaron ventas para facturar.</div>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
