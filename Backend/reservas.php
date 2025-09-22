<?php
include "conexion.php";

// Si se recibe un POST, procesar la reserva
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $servicio = $_POST["servicio"];

    // Paso 1: Verificar si la hora ya está reservada
    $sql_check = "SELECT id FROM reservas WHERE fecha = ? AND hora = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $fecha, $hora);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // La hora ya está ocupada
        $response = ['status' => 'error', 'message' => 'Esa hora ya ha sido reservada.'];
        echo json_encode($response);
        $stmt_check->close();
        $conn->close();
        exit;
    }
    $stmt_check->close();

    // Paso 2: Si no está ocupada, proceder con la inserción
    $sql_insert = "INSERT INTO reservas (nombre, telefono, fecha, hora, servicio) 
                   VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssss", $nombre, $telefono, $fecha, $hora, $servicio);

    if ($stmt_insert->execute()) {
        $response = ['status' => 'success', 'message' => 'Reserva realizada con éxito. Te esperamos, ' . htmlspecialchars($nombre) . '!'];
    } else {
        $response = ['status' => 'error', 'message' => 'Ocurrió un error al procesar tu reserva.'];
    }
    $stmt_insert->close();
    $conn->close();
    echo json_encode($response);
    exit;
}

// Si se recibe un GET (desde el script fetch), devolver los datos
$sql_servicios = "SELECT nombre FROM servicios";
$result_servicios = $conn->query($sql_servicios);
$servicios = [];
if ($result_servicios->num_rows > 0) {
    while ($row = $result_servicios->fetch_assoc()) {
        $servicios[] = $row;
    }
}

$sql_reservas = "SELECT fecha, hora FROM reservas";
$result_reservas = $conn->query($sql_reservas);
$reservas = [];
if ($result_reservas->num_rows > 0) {
    while ($row = $result_reservas->fetch_assoc()) {
        $reservas[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['servicios' => $servicios, 'reservas' => $reservas]);
?>