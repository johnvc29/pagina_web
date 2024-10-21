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

// Obtener productos desde la base de datos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ventas de Aceites</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Ventas de Aceites</h2>
        <form action="procesar_venta.php" method="post">
            <label for="producto">Seleccione el Aceite:</label>
            <select name="producto" id="producto">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?> - $<?= $row['precio'] ?></option>
                <?php } ?>
            </select>
            <br>
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" min="1" required>
            <br>
            <button type="submit">Procesar Venta</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>