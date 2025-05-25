<?php
$host = "localhost";
$port = "5432";
$dbname = "hoteles";
$user = "postgres";
$password = "password123###$$<youcantseeit>";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error al conectar a la base de datos: " . pg_last_error());
}
?>