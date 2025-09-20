<?php
include "conexion.php";

$sql = "SELECT id, nombre, telefono FROM clientes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generar las filas de la tabla con los datos
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["telefono"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No hay clientes registrados aún.</td></tr>";
}
$conn->close();
?>