<?php

require "../dbconn.php";           // Conexion a la db
require "../session.php";          // Archivo que almacena la sesion de usuario

// Verifica que el usuario haya iniciado sesion y sea administrador
if (isset($isAdmin)) {
    if (!$isAdmin) {
        alertJS("Debes ser administrador para tener acceso");
        die("<a href='../'>Volver</a>");
    }
} else {
    alertJS("Debes iniciar sesion para acceder aqui");
    die("<a href='../login.php'>Iniciar sesion</a>");
}

// Aqui inicia el archivo real
if (($_SERVER['REQUEST_METHOD'] == "POST") && (substr($_SERVER['HTTP_REFERER'], -15) == "usersconfig.php")) {

    $userID = $_POST['userID'];
    $userName = $_POST['userName'];
    $userActive;
    $userActive = isset($_POST['userActive']) ? 1 : 0;
    $userIsAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    $query = "UPDATE testforum_users SET user = '$userName', active = $userActive, isadmin = $userIsAdmin WHERE id = $userID";
    $conn->query($query);

    header("Location: usersconfig.php");
    exit;
}
if (($_SERVER['REQUEST_METHOD'] == "POST") && (substr($_SERVER['HTTP_REFERER'], -15) == "postsconfig.php")) {
    
    
    
    header("Location: usersconfig.php");
    exit;
}


?>