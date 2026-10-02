<?php

$conn = new mysqli("freackylandia.com", "u966749536_tester", "Cmamut28", "u966749536_pruebas");

if ($conn->error) {
    die("No se pudo conectar a la base de datos " . $conn->error);
}

?>