<?php
session_start();

// Proteger la página. Si no hay sesión iniciada, redirige al login.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "No autorizado. <a href='../Frontend/login.html'>Iniciar sesión</a>";
    exit;
}

include "conexion.php";

$sql = "SELECT nombre, telefono, fecha, hora, servicio FROM reservas ORDER BY fecha DESC, hora DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["fecha"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["hora"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["servicio"]) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay reservas registradas.</td></tr>";
}
$conn->close();
?>