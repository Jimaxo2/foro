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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar posts</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/index_style.css">
    <script src="../scripts/scriptsjs.js"></script>
</head>
<body>
    <style>
        body {
            background-image: none;
            margin: 10px;
        }
    </style>
    <form method="GET" action="">
        <label>Post ID</label><br>
        <input type="text" name="postID"><br>
        <label>Es respuesta</label><br>
        <input type="checkbox" name="isAnswer">
        <input type="submit" value="bsucar">
    </form>
    <?php
    // Imprimir la informacion si el usuario ya busco lo que necesita

    if (($_SERVER['REQUEST_METHOD'] == "GET") && (isset($_GET['postID']))) {

        $postID = $_GET['postID'];
        $isAnswer = isset($_GET['isAnswer']) ? 1 : 0;

        $dbTable = $isAnswer ? "testforum_answers" : "testforum";

        $query = "SELECT * FROM $dbTable WHERE id = $postID";

        $request = $conn->query($query);
        $result = $request->fetch_assoc();

        if ($dbTable == "testforum_answers") : ?>

        <!--HTML de la tabla de respuestas-->
        
        <?php endif;

        if ($dbTable == "testforum") : 
        
        $topicID = $result['id'];
        $autor = $result['autor'];
        $date = $result['date'];
        $content = $result['content'];
        $fileExist = $result['fileExist'];
        $fileType = $result['fileType'];
        $dir = $result['dir'];    
        
        ?>

        <p>Topic ID: <?php echo $topicID;?></p>
        <p>Autor: <?php echo $autor;?></p>
        <p>Fecha: <?php echo $date;?></p>
        <p>Contenido: </p>
        <p><?php echo $content;?></p>
        <p><?php echo ($fileExist ? "Directorio / Url: $dir" : "Directorio / Url: Vacio");?></p>

        <?php endif;

    }
    
    ?>
</body>
</html>
