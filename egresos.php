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

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $concepto = $conn->real_escape_string($_POST["concepto"]);
    $monto = $conn->real_escape_string($_POST["monto"]);
    $fecha = $conn->real_escape_string($_POST["fecha"]);

    $sql = "INSERT INTO egresos (concepto, monto, fecha) VALUES ('$concepto', $monto, '$fecha')";
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Egreso registrado exitosamente.";
    } else {
        $mensaje = "Error al registrar el egreso: " . $conn->error;
    }
}

// Obtener los egresos registrados
$sql = "SELECT * FROM egresos ORDER BY fecha DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Egresos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Egreso</h2>

        <!-- Mostrar mensaje -->
        <?php if (isset($mensaje)) { ?>
            <div class="message"><?= $mensaje ?></div>
        <?php } ?>

        <!-- Formulario para registrar egresos -->
        <form action="egresos.php" method="post">
            <label for="concepto">Concepto:</label>
            <input type="text" id="concepto" name="concepto" required>

            <label for="monto">Monto:</label>
            <input type="number" id="monto" name="monto" step="0.01" required>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <button type="submit">Registrar Egreso</button>
        </form>

        <h2>Listado de Egresos</h2>
        <!-- Tabla para mostrar los egresos -->
        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['concepto'] ?></td>
                        <td>$<?= number_format($row['monto'], 2) ?></td>
                        <td><?= $row['fecha'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>