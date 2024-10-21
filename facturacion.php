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

// Obtener las ventas que aún no están facturadas
$sql = "SELECT v.id, p.nombre, v.cantidad, v.total, v.fecha 
        FROM ventas v
        JOIN productos p ON v.producto_id = p.id
        LEFT JOIN factura_detalles fd ON v.id = fd.venta_id
        WHERE fd.venta_id IS NULL";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Factura</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Generar Factura</h2>

        <?php if ($result->num_rows > 0) { ?>
            <form action="generar_factura.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Fecha de Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><input type="checkbox" name="ventas[]" value="<?= $row['id'] ?>"></td>
                                <td><?= $row['nombre'] ?></td>
                                <td><?= $row['cantidad'] ?></td>
                                <td>$<?= $row['total'] ?></td>
                                <td><?= $row['fecha'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="submit">Generar Factura</button>
            </form>
        <?php } else { ?>
            <div class="message error">No hay ventas disponibles para facturar.</div>
        <?php } ?>

    </div>
</body>
</html>

<?php
$conn->close();
?>
