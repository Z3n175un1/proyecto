<?php
session_start(); // Iniciar sesión

include("../config/conn.php");

$idusuario = $_POST['idusuario'] ?? '';
$contra = $_POST['contra'] ?? '';

if ($idusuario && $contra) {
    // Prevenir inyección con parámetros
    $query = "SELECT * FROM proyecto.usuario WHERE idusuario = $1 AND contra = $2";
    $result = pg_query_params($conn, $query, array($idusuario, $contra));

    if ($result && pg_num_rows($result) === 1) {
        // Guardamos el usuario en sesión
        $_SESSION['idusuario'] = $idusuario;

        // Redirigir a la página principal
        header("Location: ../public/index.php"); // Asegúrate de que esta ruta esté bien
        exit();
    } else {
        echo "<p style='color:red;'>Usuario o contraseña incorrectos</p>";
    }
} else {
    echo "<p style='color:red;'>Por favor completa todos los campos</p>";
}
?>
