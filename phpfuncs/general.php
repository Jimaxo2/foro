<?php

function alertJS($msg) {
    // Esta funcion imprime una funcion alert de JS desde php
    echo "<script>alert('$msg');</script>";
}

// Funciones de login y create account
function verifyUserExist($conn, $user) {
    // Verifica que el usuario exista en la DB, si existe regresa true
    $query = "SELECT COUNT(*) AS total FROM testforum_users WHERE USER = '$user';";
    $result = $conn->query($query);
    $result = mysqli_fetch_assoc($result);
    if ($result['total'] >= 1) {
        return true;
    }
    return false;
}
function insertNewUserInDB($conn, $user, $password) {
    // Inserta el nuevo usuario en la base de datos
    $password = hash('sha256', $password);
    $query = "INSERT INTO testforum_users (user, password) VALUE ('$user', '$password')";
    $conn->query($query);
}

// Funciones para hacer un post
function isYTUrl($url) {
    // Verifica que la URL insertada sea de youtube
    $bool = substr($url, 12, 11) == "youtube.com";
    return $bool;
}
function vidID($url) {
    // Obtiene la ID de video de YouTube para despues separarla y devolverla
    $lengthURL = strlen($url);
    $vidID = substr($url, 32, $lengthURL);
    return $vidID;
}

?>