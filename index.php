<?php

require "dbconn.php";           // Conexion a la db
require "session.php";          // Archivo que almacena la sesion de usuario

if (!isset($user)) {
    $user = "";
    $isAdmin = false;
}
if ($isAdmin) {
    // Agregar las variables de administrador
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro</title>
    <link rel="icon" src="https://freackylandia.com/img/borger_trans.png">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/index_style.css">
    <script src="scripts/scriptsjs.js"></script>
</head>

<body>
    
    <header>
        <nav>
            <img src="https://freackylandia.com/img/borger_trans.png" width="200px">
            <div style="text-align: center;">
                <h1>Freackylandia Foro</h1>
                <?php if (!empty($user)) {
                    echo "<p>Bienvenido $user</p>";
                }; ?>
            </div>
            <div class="nav-options">
                <?php if (!empty($user)) {
                    echo "<a href='logout.php'>Cerrar sesion</a>";
                } else {
                    echo "<a href='login.php'>Iniciar sesion</a>";
                }
                if ($isAdmin) {
                    echo "<a href='adminpanel/'>Panel Administrativo</a>";
                }
                ?>
            </div>
        </nav>
    </header>
    <main>
        <section><!-- Lugar para postear -->
            <center>
                <?php if (!empty($user)): ?>
                    <button onclick="topicPostMenuToggle()" style="margin: 1rem;">Crear Post</button>
                <?php endif ?>
                <div class="MenuToggle postArea">
                    <form action="posting.php" method="post" enctype="multipart/form-data">
                        <label>Contenido</label><br>
                        <textarea name="content" required></textarea><br>
                        <label>url (solo enlaces de YouTube)</label><br>
                        <input type="url" name="url"><br>
                        <label>Archivo</label><br>
                        <input type="file" name="userfile"><br>
                        <input type="submit" value="Publicar"><br>
                    </form>
                </div>
            </center>
        </section>
        <section class="section_topic"><!-- Mostrar los mensajes -->

            <?php

            $request = $conn->query("SELECT * FROM testforum ORDER BY id DESC");

            while ($result = $request->fetch_assoc()) {

                $id = $result['id'];
                $autor = $result['autor'];
                $date = $result['date'];
                $content = $result['content'];
                $fileExist = $result['fileExist'];
                $fileType = $result['fileType'];
                $dir = $result['dir'];

                if ($fileExist == true) { // Despliega el html si existe url o imagen

                    if ($fileType == "image") : // Codigo de imagen 
            ?>

                        <div class="topic">
                            <p><?php echo $autor . " - " . $date; ?></p>
                            <p style="white-space: pre-line;"><?php echo $content; ?></p>
                            <img src="<?php echo $dir; ?>">
                            <?php
                            if (!empty($user)):
                            ?>
                                <div>
                                    <form action="resp.php" method="get">
                                        <input type="hidden" name="topicID" value="<?php echo $id; ?>">
                                        <input type="submit" value="Ver respuestas">
                                    </form>
                                </div>
                            <?php endif; ?>
                            <div class="separator"></div>
                        </div>

                    <?php elseif ($fileType == "url") : // Codigo de url de video 
                    ?>

                        <div class="topic">
                            <p><?php echo $autor . " - " . $date; ?></p>
                            <p style="white-space: pre-line;"><?php echo $content; ?></p>
                            <iframe
                                width="560"
                                height="315"
                                src="<?php echo $dir; ?>"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                            <?php
                            if (!empty($user)):
                            ?>
                                <div>
                                    <form action="resp.php" method="get">
                                        <input type="hidden" name="topicID" value="<?php echo $id; ?>">
                                        <input type="submit" value="Ver respuestas">
                                    </form>
                                </div>
                            <?php endif; ?>
                            <div class="separator"></div>
                        </div>

                    <?php endif;
                } else { // Imprime el codigo de un post comun
                    ?>

                    <div class="topic">
                        <p><?php echo $autor . " - " . $date; ?></p>
                        <p style="white-space: pre-line;"><?php echo $content; ?></p>
                        <?php
                        if (!empty($user)):
                        ?>
                            <div>
                                <form action="resp.php" method="get">
                                    <input type="hidden" name="topicID" value="<?php echo $id; ?>">
                                    <input type="submit" value="Ver respuestas">
                                </form>
                            </div>
                        <?php 
                        endif;
                        ?>
                        <div class="separator"></div>
                    </div>

            <?php
                }
            }

            ?>

        </section>
    </main>
</body>

</html>