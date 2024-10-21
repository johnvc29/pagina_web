<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menú de Navegación</title>
</head>
<body>
    <h2>Menú de Navegación</h2>
    <ul>
        <li>
            <a href="ventas.php">
                <img src="ventas.png" alt="Ventas" width="50" style="vertical-align: middle;">
                VENTAS
            </a>
        </li>
        <li>
            <a href="compras.php">
                <img src="carrito.png" alt="Compras" width="50" style="vertical-align: middle;">
                COMPRAS
            </a>
        </li>
        <li>
            <a href="facturacion.php">
                <img src="facturacion.png" alt="Facturación" width="50" style="vertical-align: middle;">
                FACTURACION
            </a>
        </li>
        <li>
            <a href="ingresos.php">
                <img src="ingresos.png" alt="Ingresos" width="50" style="vertical-align: middle;">
                INGRESOS
            </a>
        </li>
        <li>
            <a href="egresos.php">
                <img src="egresos.png" alt="Egresos" width="50" style="vertical-align: middle;">
                EGRESOS
            </a>
        </li>
        <li>
            <a href="logout.php">
                <img src="salida.png" alt="Salir" width="50" style="vertical-align: middle;">
                SALIR
            </a>
        </li>
    </ul>
</body>
</html>