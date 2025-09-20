<?php
include "conexion.php";

$sql = "SELECT nombre, precio FROM servicios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Definir un mapeo de nombres de servicio a iconos
    $iconos = [
        'Corte de Cabello' => 'fas fa-cut',
        'Corte y Barba' => 'fas fa-cut-line',
        'Corte, Barba y Facial' => 'fas fa-face-shave',
        'Afeitado Clásico' => 'fas fa-face-shave',
        'Diseño de Barba' => 'fas fa-beard',
        'Tratamiento Facial' => 'fas fa-spa',
        'Mascarilla Negra' => 'fas fa-mask',
        'Peinado y Estilizado' => 'fas fa-hair-dryer',
        'Corte Infantil' => 'fas fa-child',
    ];

    while($row = $result->fetch_assoc()) {
        $nombre = $row["nombre"];
        $precio = $row["precio"];
        $icono = isset($iconos[$nombre]) ? $iconos[$nombre] : 'fas fa-star'; // Ícono por defecto

        echo "<div class='servicio-card'>";
        echo "<i class='" . $icono . " fa-3x'></i>";
        echo "<h3>" . $nombre . "</h3>";
        echo "<p>Descripción del servicio.</p>";
        echo "<span class='precio'>$" . number_format($precio, 2) . " MXN</span>";
        echo "<a href='reservas.html' class='btn'>Reservar</a>";
        echo "</div>";
    }
} else {
    echo "<div>No se encontraron servicios.</div>";
}
$conn->close();
?>