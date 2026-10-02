<?php

require "dbconn.php";
require "session.php";

// Comprueba que en la variable sesion que esta ligada a $user este vacia
if (!empty($user)) {
    header("Location: index.php");
    exit;
}
// Si viene de crearse su cuenta el usuario muestra este mensaje
if ((substr($_SERVER['HTTP_REFERER'], -14) == "newaccount.php") && (isset($_SESSION['newuser']))) {
    alertJS("Su cuenta fue creada exitosamente");
    unset($_SESSION['newuser']);
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Comprueba que el usuario provenga de un formulario
    $user = $_POST['user'];
    $password = $_POST['password'];

    $query = "SELECT * FROM testforum_users WHERE user = '$user'";
    $result = $conn->query($query);
    $result = $result->fetch_assoc();

    if (htmlspecialchars($user) == htmlspecialchars($result['user'])) {

        // Comprueba que el usuario existe
        $password = hash('sha256', $password);
        
        if ($password == $result['password']) {

            // Establece en el archivo de session la cuenta del usuario
            $_SESSION['user'] = $user;
            $_SESSION['isAdmin'] = $result['isadmin'];
            $_SESSION['id'] = $result['id'];
            $_SESSION['active'] = $result['active'];
            header("Location: index.php");
            exit;
            
        } else {
            // Si introdujo contraseña incorrecta, salta este mensaje
            alertJS("Contraseña incorrecta");
        }
    } else {
        // Si no existe el usuario, salta el mensaje
        $msg = "No se encontró el usuario " . $user;
        alertJS($msg);
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>
    <link rel="icon" src="https://freackylandia.com/img/borger_trans.png">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <nav>
            <img src="https://freackylandia.com/img/borger_trans.png" width="200px">
            <h1>Iniciar sesion</h1>
            <div class="nav-options">
                <a href="index.php">Volver</a><!-- Agregar la opcion de iniciar sesion -->
                <a href="index.php">Foro</a> 
            <div>
        </nav>
    </header>
    <main>
        <section>
            <center>
                <form action="" method="post">
                    <label>Ingrese su nombre de usuario:</label><br>
                    <input type="text" name="user" required><br>
                    <label>Ingrese su contraseña</label><br>
                    <input type="password" name="password" required><br>
                    <input type="submit" value="Iniciar sesion"><br>
                </form>
                <p>¿No tienes una cuenta? <a href="newaccount.php">Click aqui</a> para crear una cuenta</p>
            </center>
        </section>
    </main>
</body>
</html>