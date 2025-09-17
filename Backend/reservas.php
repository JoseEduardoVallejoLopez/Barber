<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    $sql = "INSERT INTO reservas (nombre, telefono, fecha, hora) 
            VALUES ('$nombre','$telefono','$fecha','$hora')";

    if ($conn->query($sql) === TRUE) {
        echo "Reserva realizada con éxito";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>