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

// Variiables de configuracion de usuario seleccionado en userconfig.php
$userID = $_POST['id'];
$query = "SELECT * FROM testforum_users WHERE id = $userID";

$request = $conn->query($query);
$result = $request->fetch_assoc();

$userID = $result['id'];
$userName = $result['user'];
$userActive = $result['active'];
$userIsAdmin = $result['isadmin'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar configuracion de usuario</title>
</head>

<body>
    <a href="usersconfig.php">Volver</a><br><br>
    <form action="updatedata.php" method="post">
        <input type="hidden" name="userID" value="<?php echo $userID;?>">
        <label>ID de usuario: <span style="text-decoration: solid;"><?php echo $userID;?></span></label><br>
        <label>Usuario: </label>
        <input type="text" name="userName" value="<?php echo $userName;?>"><br>
        <label>Cuenta habilitada: </label>
        <input type="checkbox" name="userActive" <?php if ($userActive) {echo "checked";}?>><br>
        <label>Es administrador: </label>
        <input type="checkbox" name="isAdmin" <?php if ($userIsAdmin) {echo "checked";}?>><br>
        <input type="submit" value="Guardar">
    </form>
</body>

</html>