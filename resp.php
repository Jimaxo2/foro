<?php

require "dbconn.php";           // Conexion a la db
require "session.php";          // Archivo que almacena la sesion de usuario

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['topicID'])) {
    $topicID = $_GET['topicID'];
} else if (isset($_SESSION['theanswer'])) {
    $topicID = $_SESSION['theanswer'];
    unset($_SESSION['theanswer']);
} else {

    header("Location: /");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta <?php echo $topicID; ?></title>
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
                <a href="index.php">Volver</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="section_topic">
            <div>
                <?php

                $query = "SELECT * FROM testforum WHERE id = $topicID";
                $request = $conn->query($query);
                $result = $request->fetch_assoc();

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
                            <div class="separator"></div>
                        </div>

                <?php endif;
                } else { // Imprime el codigo de un post comun
                ?>

                    <div class="topic">
                        <p><?php echo $autor . " - " . $date; ?></p>
                        <p style="white-space: pre-line;"><?php echo $content; ?></p>
                        <div class="separator"></div>
                    </div>

                <?php

                }

                ?>
            </div>
        </section>
        <section>
            <center>
                <?php if (!empty($user)): ?>
                    <button onclick="topicPostMenuToggle()" style="margin: 1rem;">Responder este post</button>
                <?php endif ?>
                <div class="MenuToggle postArea">
                    <form action="posting.php" method="post">
                        <label>Respuesta</label><br>
                        <textarea name="answer" required></textarea><br>
                        <input type="hidden" name="topicID" value="<?php echo $topicID; ?>">
                        <input type="submit" value="Responder"><br>
                    </form>
                </div>
            </center>
        </section>
        <section class="section_topic">
            <?php

            $query = "SELECT * FROM testforum_answers WHERE topicID = $topicID";
            $request = $conn->query($query);

            while ($result = $request->fetch_assoc()) {

                $answerID = $result['id'];
                $answerAutor = $result['autor'];
                $answerDate = $result['date'];
                $answerContent = $result['content'];

                ?>

                <div class="topic">
                    <p><?php echo $answerAutor . " - " . $answerDate; ?></p>
                    <p style="white-space: pre-line;"><?php echo $answerContent; ?></p>
                    <div class="separator"></div>
                </div>

            <?php

            }

            ?>
        </section>
    </main>
</body>

</html>