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
    <title>Configuracion de usuarios</title>
</head>
<body>
    <main>
        <section>
            <table>
                <thead>
                <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Activo</th>
                <th>Es admin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $request = $conn->query("SELECT * FROM testforum_users");
                
                while ($result = $request->fetch_assoc()) {

                    $userID = $result['id'];
                    $userName = $result['user'];
                    $userActive = $result['active'];
                    $userIsAdmin = $result['isadmin'];
                    
                    ?>
                    <tr>
                    <th><?php echo $userID;?></th>
                    <th><?php echo $userName;?></th>
                    <th><?php echo $userActive;?></th>
                    <th><?php echo $userIsAdmin;?></th>
                    <th><form action="edituserconfig.php" method="post"><input type="hidden" name='id' 
                        value="<?php echo "$userID";?>"><input type="submit" value="Editar"></form></th>
                    </tr>
                    <?php

                }

                ?>
            </tbody>
            </table>
        </section>
    </main>
</body>
</html>