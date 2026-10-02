<?php

require "dbconn.php";           // Conexion a la db
require "session.php";          // Archivo que almacena la sesion de usuario

if (!empty($user)) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $autor = $user;
        $date = date("Y-m-d H:i:s");
        $content = $_POST['content'];
        $url = $_POST['url'];

        $query; // <- Esta variable se encargara de insertar los datos en la base de datos segun el caso

        // Estas variables definen si existen archivo o url
        $fileExist = is_uploaded_file($_FILES['userfile']['tmp_name']);
        $urlExist = !empty($url);

        // Este if se asegura de que un archivo y una url no se suban al mismo tiempo
        if ($fileExist && $urlExist) {
            alertJS("No puedes enviar un archivo y una url al mismo tiempo");
            die("<a href='/'> Volver </a>");
        }
        if ($fileExist) {
            // Comprueba que el archivo sea una imagen
            if ((substr($_FILES['userfile']['type'], 0, 5) != "image")) {
                alertJS("El tipo de archivo debe ser una imagen");
                die("<a href='/'> Volver </a>");
            }
            // Definimos las variables que determinan valores del archivo
            $fileType = substr($_FILES['userfile']['type'], 0, 5);
            $fileName = basename($_FILES['userfile']['name']);
            $fileTempName = $_FILES['userfile']['tmp_name'];

            // Esta funcion mueve el archivo a la carpeta files
            $dir = "files/" . $fileName;
            move_uploaded_file($fileTempName, $dir);

            // Esta consulta introduce la informacion en la base de datos
            $query = "INSERT INTO testforum (autor, date, content, fileExist, fileType, dir) VALUE ('$autor', '$date', '$content', $fileExist, '$fileType', '$dir')";
            $conn->query($query);
            
            header("Location: index.php");
            exit;

        }
        else if ($urlExist) {
            // Comprueba que la url sea de youtube
            if (isYTUrl($url)) {
                // Determina la id del video a subir
                $vidID = vidID($url);

                // Determina los valores que se insertaran en la base de datos
                $fileExist = true;
                $fileType = "url";
                $dir = "https://www.youtube.com/embed/" . $vidID;

                // Realiza la consulta para insertar los datos
                $query = "INSERT INTO testforum (autor, date, content, fileExist, fileType, dir) VALUE ('$autor', '$date', '$content', $fileExist, '$fileType', '$dir')";
                $conn->query($query);

                header("Location: index.php");
                exit;

            } else {
                alertJS("La url debe ser de youtube");
                die("<a href='/'> Volver </a>");
            }
        }
        else if (!$urlExist && !$fileExist && !empty($content)) {
            $query = "INSERT INTO testforum (autor, date, content) VALUE ('$autor', '$date', '$content')";
            $conn->query($query);

            header("Location: index.php");
            exit;
        }

        // Esta parte es para postear respuestas
        if (isset($_POST['answer'])) {

            $autor = $user;
            $topicID = $_POST['topicID'];
            $content = $_POST['answer'];
            $date = date("Y-m-d H:i:s");

            $query = "INSERT INTO testforum_answers (autor, date, content, topicID) VALUES ('$autor', '$date', '$content', $topicID)";
            $conn->query($query);

            $_SESSION['theanswer'] = $topicID;

            header("Location: resp.php?topicID=$topicID");
            exit;

        }

    } else {
        alertJS("No deberias estar aqui");
        echo "<a href='/'> Volver </a>";
    }
} else {
    alertJS("Debes iniciar sesion para poder hacer un post");
    echo "<a href='/'> Volver </a>";
}

?>