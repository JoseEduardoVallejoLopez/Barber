<?php
session_start();
include "conexion.php";

if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT id, nombre, contrasena FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($contrasena === $user['contrasena']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            header("Location: ../Frontend/clientes.html");
            exit;
        } else {
            header("Location: ../Frontend/login.html");
            exit;
        }
    } else {
        header("Location: ../login.html");
        exit;
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.html");
    exit;
}

$conn->close();
?>