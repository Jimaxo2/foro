<?php

require "phpfuncs/general.php"; // Archivo de funciones
include_once "dbconn.php";

session_start();

if (isset($_SESSION['user'])) {

    $query = "SELECT active FROM testforum_users WHERE id = " . $_SESSION['id'];
    $request = $conn->query($query);
    $result = $request->fetch_assoc();

    $_SESSION['active'] = $result['active'];

    $id = $_SESSION['id'];
    $user = $_SESSION['user'];
    $activeUser = $_SESSION['active'];
    $isAdmin = $_SESSION['isAdmin'];

    if (!$activeUser){
        die(alertJS("Tu cuenta esta desabilitada") . "<a href='logout.php'>Cerrar sesion</a>");
    }

}

?>