<?php

require "../dbconn.php";           // Conexion a la db
require "../session.php";          // Archivo que almacena la sesion de usuario

// Verifica que el usuario haya iniciado sesion
if (isset($isAdmin)) {
    if (!$isAdmin) {
        alertJS("Debes ser administrador para tener acceso");
        die("<a href='../'>Volver</a>");
    }
} else {
    alertJS("Debes iniciar sesion para acceder aqui");
    die("<a href='../login.php'>Iniciar sesion</a>");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
</head>
<body>
    <style>
        body {
            background-image: none;
        }
    </style>
    <header>
        <a href="../">Foro principal</a>
    </header>
    <section>
        <div>
            <h1>Panel administrativo</h1>
            <li>
                <lo><a href="usersconfig.php">Users config</a></lo><!--Configuracion de usuarios-->
                <lo><a href="postsconfig.php">Posts config</a></lo><!--Configuracion de posts-->
            </li>
        </div>
    </section>
</body>
</html>