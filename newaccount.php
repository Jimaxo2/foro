<?php

require "dbconn.php";
require "phpfuncs/general.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Comprobar que venga el usuario de un formulario
    // y declaramos variables
    $newuser = $_POST['newuser'];
    $newpassword1 = $_POST['newpassword1'];
    $newpassword2 = $_POST['newpassword2'];

    // Este if se asegura de que se ingresen los datos adecuados
    if (empty($newuser) || empty($newpassword1) || empty($newpassword2) || ($newpassword1 != $newpassword2)) {
        if ($newpassword1 != $newpassword2) {
            alertJS("Las contraseñas no coinciden, vuelvelo a intentar");
        } else {
            alertJS("Necesitas ingresar todos los datos");
        }
    } else {
       
        // Este if se asegura de que los usuarios no se repitan
        if (verifyUserExist($conn, $newuser)) {
            alertJS("El usuario $newuser ya esta registrado, favor de ingresar uno diferente");
        } else {
            //Aqui ya se registra el usuario en la DB
            insertNewUserInDB($conn, $newuser, $newpassword1);
            session_start();
            $_SESSION['newuser'] = true;
            header("Location: login.php");
            exit;
        }

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta nueva</title>
    <link rel="icon" src="https://freackylandia.com/img/borger_trans.png">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <nav>
            <img src="https://freackylandia.com/img/borger_trans.png" width="200px">
            <h1>Crear cuenta</h1>
            <div class="nav-options">
                <a href="login.php">Iniciar sesion</a><!-- Agregar la opcion de iniciar sesion -->
                <a href="index.php">Foro</a> 
            <div>
        </nav>
    </header>
    <main>
        <section>
            <center>
                <form action="" method="post">
                    <label>Ingrese su nombre de usuario:</label><br>
                    <input type="text" name="newuser" required><br>
                    <label>Ingrese su contraseña</label><br>
                    <input type="password" name="newpassword1" required><br>
                    <label>Confirmar contraseña</label><br>
                    <input type="password" name="newpassword2" required><br>
                    <input type="submit" value="Crear cuenta"><br>
                </form>
            </center>
        </section>
    </main>
</body>
</html>